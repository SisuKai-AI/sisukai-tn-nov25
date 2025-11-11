<?php

namespace Database\Seeders\Questions;

class CompTIANetworkQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'comptia-network-plus';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Networking Concepts' => [
                $this->q('What is the OSI model?', [$this->correct('A conceptual framework with 7 layers describing network communication'), $this->wrong('A physical network device'), $this->wrong('A type of cable'), $this->wrong('A wireless standard')], 'The OSI (Open Systems Interconnection) model has 7 layers: Physical, Data Link, Network, Transport, Session, Presentation, and Application.', 'easy', 'approved'),
                $this->q('Which layer of the OSI model is responsible for logical addressing?', [$this->correct('Network Layer (Layer 3)'), $this->wrong('Data Link Layer (Layer 2)'), $this->wrong('Transport Layer (Layer 4)'), $this->wrong('Application Layer (Layer 7)')], 'The Network Layer handles logical addressing (IP addresses) and routing between networks.', 'medium', 'approved'),
                $this->q('What is the default subnet mask for a Class C network?', [$this->correct('255.255.255.0'), $this->wrong('255.255.0.0'), $this->wrong('255.0.0.0'), $this->wrong('255.255.255.255')], 'Class C networks use 255.255.255.0 (/24), providing 254 usable host addresses.', 'easy', 'approved'),
            ],
            'Network Infrastructure' => [
                $this->q('What is the primary function of a router?', [$this->correct('To forward packets between different networks'), $this->wrong('To connect devices on the same network'), $this->wrong('To amplify network signals'), $this->wrong('To store network data')], 'Routers operate at Layer 3 and forward packets between different networks based on IP addresses.', 'easy', 'approved'),
                $this->q('What is a VLAN?', [$this->correct('A Virtual Local Area Network that logically segments a physical network'), $this->wrong('A type of physical cable'), $this->wrong('A wireless access point'), $this->wrong('A network monitoring tool')], 'VLANs allow network segmentation at Layer 2, creating separate broadcast domains on the same physical infrastructure.', 'medium', 'approved'),
                $this->q('Which protocol is used for automatic IP address assignment?', [$this->correct('DHCP'), $this->wrong('DNS'), $this->wrong('FTP'), $this->wrong('SMTP')], 'DHCP (Dynamic Host Configuration Protocol) automatically assigns IP addresses and network configuration to devices.', 'easy', 'approved'),
            ],
            'Network Operations' => [
                $this->q('What is the purpose of DNS?', [$this->correct('To translate domain names to IP addresses'), $this->wrong('To assign IP addresses automatically'), $this->wrong('To encrypt network traffic'), $this->wrong('To route packets between networks')], 'DNS (Domain Name System) resolves human-readable domain names (like google.com) to IP addresses.', 'easy', 'approved'),
                $this->q('Which command tests connectivity to a remote host?', [$this->correct('ping'), $this->wrong('ipconfig'), $this->wrong('tracert'), $this->wrong('nslookup')], 'The ping command sends ICMP echo requests to test connectivity and measure round-trip time.', 'easy', 'approved'),
                $this->q('What does QoS stand for?', [$this->correct('Quality of Service'), $this->wrong('Queue of Services'), $this->wrong('Quick Operating System'), $this->wrong('Quantum of Speed')], 'QoS prioritizes network traffic to ensure critical applications receive adequate bandwidth and low latency.', 'medium', 'approved'),
            ],
            'Network Security' => [
                $this->q('What is the purpose of a firewall?', [$this->correct('To filter network traffic based on security rules'), $this->wrong('To increase network speed'), $this->wrong('To assign IP addresses'), $this->wrong('To resolve domain names')], 'Firewalls monitor and control incoming and outgoing network traffic based on predetermined security rules.', 'easy', 'approved'),
                $this->q('Which encryption protocol is used in WPA2?', [$this->correct('AES (Advanced Encryption Standard)'), $this->wrong('DES'), $this->wrong('MD5'), $this->wrong('SHA-1')], 'WPA2 uses AES encryption, which is much more secure than the TKIP used in WPA.', 'medium', 'approved'),
                $this->q('What port does HTTPS use?', [$this->correct('443'), $this->wrong('80'), $this->wrong('22'), $this->wrong('25')], 'HTTPS uses port 443 for secure web traffic, while HTTP uses port 80.', 'easy', 'approved'),
            ],
            'Network Troubleshooting' => [
                $this->q('A user can access local resources but not the internet. What is the most likely problem?', [$this->correct('Default gateway misconfiguration'), $this->wrong('Bad network cable'), $this->wrong('Incorrect subnet mask'), $this->wrong('Disabled NIC')], 'If local access works but internet doesn\'t, the default gateway (router) configuration is likely incorrect.', 'medium', 'approved'),
                $this->q('What does the command "ipconfig /release" do?', [$this->correct('Releases the current DHCP-assigned IP address'), $this->wrong('Shows current IP configuration'), $this->wrong('Renews the DHCP lease'), $this->wrong('Flushes the DNS cache')], 'ipconfig /release releases the current DHCP IP address. Use ipconfig /renew to obtain a new one.', 'medium', 'approved'),
                $this->q('Which tool shows the path packets take to reach a destination?', [$this->correct('tracert (Windows) or traceroute (Linux/Mac)'), $this->wrong('ping'), $this->wrong('ipconfig'), $this->wrong('netstat')], 'Tracert/traceroute shows each hop (router) that packets pass through to reach the destination.', 'easy', 'approved'),
            ],
        ];
    }
}

