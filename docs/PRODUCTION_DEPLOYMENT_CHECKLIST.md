# Production Deployment Checklist - SisuKai Platform

**Project:** SisuKai Certification Landing Page Enhancement  
**Phases:** 1-8B (Complete)  
**Target:** Production Deployment  
**Date:** November 10, 2025  

---

## Pre-Deployment Preparation

### 1. Environment Configuration

#### Required Environment Variables

**Application:**
```env
APP_NAME=SisuKai
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sisukai.com
APP_KEY=base64:... # Generate with: php artisan key:generate
```

**Database:**
```env
DB_CONNECTION=mysql
DB_HOST=your-production-db-host
DB_PORT=3306
DB_DATABASE=sisukai_production
DB_USERNAME=sisukai_user
DB_PASSWORD=strong-secure-password
```

**Mail (SendGrid):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sisukai.com
MAIL_FROM_NAME="SisuKai"
```

**Stripe (Production):**
```env
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

**Paddle (Production):**
```env
PADDLE_VENDOR_ID=your_production_vendor_id
PADDLE_API_KEY=your_production_api_key
PADDLE_WEBHOOK_SECRET=your_production_webhook_secret
PADDLE_ENVIRONMENT=production
```

**Session & Cache:**
```env
SESSION_DRIVER=redis
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

**Security:**
```env
SANCTUM_STATEFUL_DOMAINS=sisukai.com,www.sisukai.com
SESSION_SECURE_COOKIE=true
```

---

### 2. Stripe Configuration

#### Create Production Products

**Monthly Subscription:**
- Product Name: "SisuKai Monthly Subscription"
- Price: $24.00 USD
- Billing Interval: Monthly
- Trial Period: 7 days
- Copy Price ID to `subscription_plans` table

**Annual Subscription:**
- Product Name: "SisuKai Annual Subscription"
- Price: $199.00 USD
- Billing Interval: Yearly
- Trial Period: 7 days
- Copy Price ID to `subscription_plans` table

**Single Certification:**
- Product Name: "SisuKai Single Certification"
- Price: $39.00 USD
- Type: One-time payment

#### Configure Stripe Webhook

1. Go to Stripe Dashboard → Developers → Webhooks
2. Add endpoint: `https://sisukai.com/webhook/stripe`
3. Select events:
   - `customer.subscription.created`
   - `customer.subscription.updated`
   - `customer.subscription.deleted`
   - `invoice.payment_succeeded`
   - `invoice.payment_failed`
   - `checkout.session.completed`
4. Copy webhook signing secret to `.env`

---

### 3. Paddle Configuration

#### Create Production Account

1. Sign up at https://paddle.com
2. Complete business verification
3. Set up bank account for payouts
4. Configure tax settings (Paddle handles as Merchant of Record)

#### Create Production Products

**Monthly Subscription:**
- Product Name: "SisuKai Monthly Subscription"
- Price: $24.00 USD
- Billing Interval: Monthly
- Trial Period: 7 days
- Copy Price ID to `subscription_plans.paddle_price_id_monthly`

**Annual Subscription:**
- Product Name: "SisuKai Annual Subscription"
- Price: $199.00 USD
- Billing Interval: Yearly
- Trial Period: 7 days
- Copy Price ID to `subscription_plans.paddle_price_id_yearly`

**Single Certification:**
- Product Name: "SisuKai Single Certification"
- Price: $39.00 USD
- Type: One-time payment
- Copy Price ID for use in checkout

#### Configure Paddle Webhook

1. Go to Paddle Dashboard → Developer Tools → Webhooks
2. Add webhook URL: `https://sisukai.com/webhook/paddle`
3. Enable all subscription and transaction events:
   - `subscription.created`
   - `subscription.updated`
   - `subscription.canceled`
   - `transaction.completed`
   - `transaction.payment_failed`
4. Copy webhook secret to `.env`

---

### 4. Database Setup

#### Update Subscription Plans

```sql
-- Update Stripe price IDs
UPDATE subscription_plans 
SET stripe_price_id = 'price_live_monthly_xxx' 
WHERE name = 'Monthly Plan';

UPDATE subscription_plans 
SET stripe_price_id = 'price_live_yearly_xxx' 
WHERE name = 'Annual Plan';

-- Update Paddle price IDs
UPDATE subscription_plans 
SET paddle_price_id_monthly = 'pri_live_monthly_xxx',
    paddle_price_id_yearly = 'pri_live_yearly_xxx'
WHERE id = 1;
```

#### Seed Initial Data

```bash
# Run migrations
php artisan migrate --force

# Seed certifications (if not already done)
php artisan db:seed --class=CertificationSeeder

# Seed subscription plans
php artisan db:seed --class=SubscriptionPlanSeeder

# Create admin user
php artisan db:seed --class=AdminUserSeeder
```

---

### 5. SendGrid Email Configuration

#### Create SendGrid Account

1. Sign up at https://sendgrid.com
2. Verify domain: `sisukai.com`
3. Create API key with full access
4. Add API key to `.env` as `MAIL_PASSWORD`

#### Configure DNS Records

Add these DNS records for email authentication:

**SPF Record:**
```
Type: TXT
Host: @
Value: v=spf1 include:sendgrid.net ~all
```

**DKIM Records:**
```
Type: CNAME
Host: s1._domainkey
Value: s1.domainkey.u12345.wl.sendgrid.net

Type: CNAME
Host: s2._domainkey
Value: s2.domainkey.u12345.wl.sendgrid.net
```

**DMARC Record:**
```
Type: TXT
Host: _dmarc
Value: v=DMARC1; p=none; rua=mailto:dmarc@sisukai.com
```

#### Test Email Delivery

```bash
php artisan tinker

# Send test email
Mail::raw('Test email from SisuKai', function($message) {
    $message->to('your-email@example.com')
            ->subject('SisuKai Email Test');
});
```

---

### 6. Server Configuration

#### Web Server (Nginx)

**SSL Certificate (Let's Encrypt):**
```bash
sudo certbot --nginx -d sisukai.com -d www.sisukai.com
```

**Nginx Configuration:**
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name sisukai.com www.sisukai.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name sisukai.com www.sisukai.com;
    root /var/www/sisukai/public;

    ssl_certificate /etc/letsencrypt/live/sisukai.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/sisukai.com/privkey.pem;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
    
    index index.php;
    
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### PHP Configuration

**php.ini optimizations:**
```ini
memory_limit = 256M
upload_max_filesize = 20M
post_max_size = 20M
max_execution_time = 60
```

#### Redis Configuration

**Install Redis:**
```bash
sudo apt-get install redis-server
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

**Configure Laravel to use Redis:**
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

---

### 7. Queue Worker Setup

#### Supervisor Configuration

**Create supervisor config:**
```bash
sudo nano /etc/supervisor/conf.d/sisukai-worker.conf
```

**Configuration:**
```ini
[program:sisukai-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/sisukai/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/sisukai/storage/logs/worker.log
stopwaitsecs=3600
```

**Start supervisor:**
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start sisukai-worker:*
```

---

### 8. Scheduled Tasks (Cron)

**Add to crontab:**
```bash
sudo crontab -e -u www-data
```

**Add this line:**
```
* * * * * cd /var/www/sisukai && php artisan schedule:run >> /dev/null 2>&1
```

**Scheduled tasks include:**
- Trial ending email (3 days before trial ends)
- Subscription renewal reminders
- Failed payment retries
- Analytics aggregation

---

## Deployment Steps

### 1. Code Deployment

```bash
# Clone repository
cd /var/www
git clone https://github.com/your-org/sisukai.git
cd sisukai

# Checkout production branch
git checkout mvp-frontend

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Set permissions
sudo chown -R www-data:www-data /var/www/sisukai
sudo chmod -R 755 /var/www/sisukai
sudo chmod -R 775 /var/www/sisukai/storage
sudo chmod -R 775 /var/www/sisukai/bootstrap/cache
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env
nano .env  # Edit with production values

# Generate application key
php artisan key:generate

# Link storage
php artisan storage:link
```

### 3. Database Migration

```bash
# Run migrations
php artisan migrate --force

# Seed initial data
php artisan db:seed --force
```

### 4. Cache Optimization

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Verify Installation

```bash
# Check application status
php artisan about

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Test queue connection
php artisan queue:work --once

# Test email
php artisan tinker
>>> Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });
```

---

## Post-Deployment Testing

### 1. Basic Functionality

- [ ] Homepage loads correctly
- [ ] Certification catalog displays 18 certifications
- [ ] Certification detail pages load
- [ ] Quiz functionality works
- [ ] Help Center loads and search works
- [ ] Blog posts display correctly

### 2. Authentication

- [ ] Admin login works
- [ ] Learner registration works
- [ ] Learner login works
- [ ] Password reset works
- [ ] Email verification works

### 3. Admin Panel

- [ ] Dashboard displays analytics
- [ ] Certification CRUD works
- [ ] Quiz question management works
- [ ] Help article management works
- [ ] Payment settings load
- [ ] Active processor can be changed

### 4. Payment Integration (Stripe)

- [ ] Pricing page displays correctly
- [ ] Subscription checkout creates Stripe session
- [ ] Stripe checkout page loads
- [ ] Test payment completes successfully
- [ ] Webhook processes subscription creation
- [ ] Trial started email sent
- [ ] User enrolled in subscription
- [ ] Subscription visible in admin panel
- [ ] User can access all certifications

### 5. Payment Integration (Paddle)

- [ ] Switch active processor to Paddle in admin
- [ ] Subscription checkout creates Paddle session
- [ ] Paddle checkout page loads
- [ ] Test payment completes successfully
- [ ] Webhook processes transaction
- [ ] Payment succeeded email sent
- [ ] User enrolled in subscription
- [ ] Subscription visible in admin panel

### 6. Single Certification Purchase

- [ ] "Buy This Certification" button works
- [ ] Checkout creates session (Stripe or Paddle)
- [ ] Payment completes successfully
- [ ] Webhook processes purchase
- [ ] User granted access to certification
- [ ] Purchase visible in billing history

### 7. Subscription Management

- [ ] Manage subscription page loads
- [ ] Subscription details display correctly
- [ ] Cancel subscription works
- [ ] Cancellation email sent
- [ ] Resume subscription works
- [ ] Billing history displays payments

### 8. Email Notifications

- [ ] Trial started email sends
- [ ] Trial ending email sends (test with scheduled task)
- [ ] Payment succeeded email sends
- [ ] Payment failed email sends
- [ ] Subscription cancelled email sends
- [ ] All emails have correct branding
- [ ] All links in emails work

### 9. SEO & Performance

- [ ] Meta tags present on all pages
- [ ] Structured data validates (Google Rich Results Test)
- [ ] Sitemap generates correctly
- [ ] Robots.txt configured
- [ ] Page load time < 3 seconds
- [ ] Mobile responsiveness works
- [ ] Images optimized and loading

### 10. Security

- [ ] HTTPS enforces on all pages
- [ ] CSRF protection works
- [ ] SQL injection protection (test with ' OR 1=1--)
- [ ] XSS protection (test with <script>alert('XSS')</script>)
- [ ] Webhook signature verification works
- [ ] Admin panel requires authentication
- [ ] Learner dashboard requires authentication

---

## Monitoring Setup

### 1. Error Tracking (Sentry)

**Install Sentry:**
```bash
composer require sentry/sentry-laravel
php artisan sentry:publish --dsn=your-sentry-dsn
```

**Configure:**
```env
SENTRY_LARAVEL_DSN=https://your-sentry-dsn@sentry.io/project-id
SENTRY_TRACES_SAMPLE_RATE=0.2
```

### 2. Application Monitoring

**Laravel Telescope (Development Only):**
```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

**Production Monitoring:**
- Use Laravel Horizon for queue monitoring
- Use New Relic or Datadog for APM
- Use CloudWatch for AWS infrastructure

### 3. Uptime Monitoring

**Recommended Services:**
- UptimeRobot (free tier available)
- Pingdom
- StatusCake

**Monitor these endpoints:**
- `https://sisukai.com` (homepage)
- `https://sisukai.com/health` (Laravel health check)
- `https://sisukai.com/webhook/stripe` (webhook endpoint)
- `https://sisukai.com/webhook/paddle` (webhook endpoint)

### 4. Log Monitoring

**Configure log rotation:**
```bash
sudo nano /etc/logrotate.d/sisukai
```

**Configuration:**
```
/var/www/sisukai/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

---

## Backup Strategy

### 1. Database Backups

**Daily automated backups:**
```bash
#!/bin/bash
# /usr/local/bin/backup-sisukai-db.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/sisukai"
DB_NAME="sisukai_production"

mkdir -p $BACKUP_DIR

mysqldump -u sisukai_user -p'password' $DB_NAME | gzip > $BACKUP_DIR/sisukai_db_$DATE.sql.gz

# Keep only last 30 days
find $BACKUP_DIR -name "sisukai_db_*.sql.gz" -mtime +30 -delete
```

**Add to crontab:**
```
0 2 * * * /usr/local/bin/backup-sisukai-db.sh
```

### 2. File Backups

**Backup storage directory:**
```bash
#!/bin/bash
# /usr/local/bin/backup-sisukai-files.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/sisukai"
SOURCE_DIR="/var/www/sisukai/storage/app"

mkdir -p $BACKUP_DIR

tar -czf $BACKUP_DIR/sisukai_files_$DATE.tar.gz $SOURCE_DIR

# Keep only last 7 days
find $BACKUP_DIR -name "sisukai_files_*.tar.gz" -mtime +7 -delete
```

### 3. Off-site Backups

**Sync to S3:**
```bash
aws s3 sync /var/backups/sisukai s3://sisukai-backups/production/
```

---

## Rollback Plan

### If Deployment Fails

**1. Revert Code:**
```bash
cd /var/www/sisukai
git reset --hard HEAD~1
composer install
npm install && npm run build
```

**2. Rollback Database:**
```bash
# Restore from backup
gunzip < /var/backups/sisukai/sisukai_db_YYYYMMDD_HHMMSS.sql.gz | mysql -u sisukai_user -p sisukai_production
```

**3. Clear Caches:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**4. Restart Services:**
```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo supervisorctl restart sisukai-worker:*
```

---

## Go-Live Checklist

### Final Verification

- [ ] All environment variables configured
- [ ] Stripe production keys added
- [ ] Paddle production keys added
- [ ] SendGrid configured and verified
- [ ] Database migrations run
- [ ] Subscription plans configured with production price IDs
- [ ] Active payment processor selected in admin
- [ ] SSL certificate installed and working
- [ ] Queue workers running
- [ ] Scheduled tasks configured
- [ ] Backups configured and tested
- [ ] Monitoring configured
- [ ] Error tracking configured
- [ ] All tests passing
- [ ] Performance optimized
- [ ] Security hardened

### Communication Plan

- [ ] Notify stakeholders of go-live date
- [ ] Prepare announcement email
- [ ] Update social media
- [ ] Monitor support channels for issues
- [ ] Have rollback plan ready

### Post-Launch Monitoring (First 24 Hours)

- [ ] Monitor error logs every hour
- [ ] Check webhook processing
- [ ] Verify email delivery
- [ ] Monitor payment success rate
- [ ] Check database performance
- [ ] Monitor server resources
- [ ] Review user feedback
- [ ] Test critical paths manually

---

## Support Contacts

**Technical Issues:**
- Laravel Support: https://laravel.com/support
- Stripe Support: https://support.stripe.com
- Paddle Support: https://paddle.com/support
- SendGrid Support: https://support.sendgrid.com

**Emergency Contacts:**
- DevOps Team: devops@sisukai.com
- Database Admin: dba@sisukai.com
- Security Team: security@sisukai.com

---

## Success Criteria

**Deployment is successful when:**

1. ✅ All 18 certifications display correctly
2. ✅ Users can register and login
3. ✅ Subscription checkout works (Stripe or Paddle)
4. ✅ Single certification purchase works
5. ✅ Webhooks process correctly
6. ✅ Emails send successfully
7. ✅ Admin panel accessible and functional
8. ✅ No critical errors in logs
9. ✅ Page load time < 3 seconds
10. ✅ SSL certificate valid
11. ✅ Backups running successfully
12. ✅ Monitoring active and alerting

**When all criteria are met, deployment is COMPLETE! 🚀**

---

**Document Version:** 1.0  
**Last Updated:** November 10, 2025  
**Prepared By:** Manus AI Agent  
**Project:** SisuKai Certification Platform  
