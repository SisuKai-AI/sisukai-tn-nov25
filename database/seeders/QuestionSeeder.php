<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Questions\AWSCertifiedCloudPractitionerQuestionSeeder;
use Database\Seeders\Questions\AWSCertifiedSolutionsArchitectAssociateQuestionSeeder;
use Database\Seeders\Questions\MicrosoftAzureFundamentalsAZ900QuestionSeeder;
use Database\Seeders\Questions\GoogleCloudDigitalLeaderQuestionSeeder;
use Database\Seeders\Questions\CertifiedKubernetesAdministratorCKAQuestionSeeder;
use Database\Seeders\Questions\CompTIASecurityQuestionSeeder;
use Database\Seeders\Questions\CertifiedInformationSystemsSecurityProfessionalCISSPQuestionSeeder;
use Database\Seeders\Questions\CertifiedEthicalHackerCEHQuestionSeeder;
use Database\Seeders\Questions\CompTIACySACybersecurityAnalystQuestionSeeder;
use Database\Seeders\Questions\GIACSecurityEssentialsGSECQuestionSeeder;
use Database\Seeders\Questions\CompTIAAQuestionSeeder;
use Database\Seeders\Questions\CompTIANetworkQuestionSeeder;
use Database\Seeders\Questions\CiscoCertifiedNetworkAssociateCCNAQuestionSeeder;
use Database\Seeders\Questions\ProjectManagementProfessionalPMPQuestionSeeder;
use Database\Seeders\Questions\ProjectManagementProfessionalPMPHardQuestionsSupplementary;
use Database\Seeders\Questions\CertifiedScrumMasterCSMQuestionSeeder;
use Database\Seeders\Questions\ITIL4FoundationQuestionSeeder;
use Database\Seeders\Questions\OracleCertifiedProfessionalJavaSEProgrammerQuestionSeeder;
use Database\Seeders\Questions\MicrosoftCertifiedAzureDataFundamentalsDP900QuestionSeeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting question bank seeding...');
        $this->command->newLine();
        
        $this->call([
            // Cloud Computing & DevOps (5 certifications)
            AWSCertifiedCloudPractitionerQuestionSeeder::class,
            AWSCertifiedSolutionsArchitectAssociateQuestionSeeder::class,
            MicrosoftAzureFundamentalsAZ900QuestionSeeder::class,
            GoogleCloudDigitalLeaderQuestionSeeder::class,
            CertifiedKubernetesAdministratorCKAQuestionSeeder::class,
            
            // Cybersecurity (5 certifications)
            CompTIASecurityQuestionSeeder::class,
            CertifiedInformationSystemsSecurityProfessionalCISSPQuestionSeeder::class,
            CertifiedEthicalHackerCEHQuestionSeeder::class,
            CompTIACySACybersecurityAnalystQuestionSeeder::class,
            GIACSecurityEssentialsGSECQuestionSeeder::class,
            
            // IT Fundamentals & Networking (3 certifications)
            CompTIAAQuestionSeeder::class,
            CompTIANetworkQuestionSeeder::class,
            CiscoCertifiedNetworkAssociateCCNAQuestionSeeder::class,
            
            // Project Management & Business (3 certifications)
            ProjectManagementProfessionalPMPQuestionSeeder::class,
            ProjectManagementProfessionalPMPHardQuestionsSupplementary::class,
            CertifiedScrumMasterCSMQuestionSeeder::class,
            ITIL4FoundationQuestionSeeder::class,
            
            // Development & Data (2 certifications)
            OracleCertifiedProfessionalJavaSEProgrammerQuestionSeeder::class,
            MicrosoftCertifiedAzureDataFundamentalsDP900QuestionSeeder::class,
        ]);
        
        $this->command->newLine();
        $this->command->info('✅ Question bank seeding completed!');
    }
}
