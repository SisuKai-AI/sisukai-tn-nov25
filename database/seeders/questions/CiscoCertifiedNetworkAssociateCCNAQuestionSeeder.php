<?php

namespace Database\Seeders\Questions;

class CiscoCertifiedNetworkAssociateCCNAQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'cisco-ccna';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Network Fundamentals' => [
                $this->q('What is the purpose of the TCP three-way handshake?', [$this->correct('To establish a reliable connection between two hosts'), $this->wrong('To terminate a connection'), $this->wrong('To assign IP addresses'), $this->wrong('To route packets')], 'The TCP three-way handshake (SYN, SYN-ACK, ACK) establishes a reliable connection before data transmission.', 'medium', 'approved'),
                $this->q('Which layer of the OSI model does a switch operate at?', [$this->correct('Layer 2 (Data Link)'), $this->wrong('Layer 1 (Physical)'), $this->wrong('Layer 3 (Network)'), $this->wrong('Layer 4 (Transport)')], 'Switches operate at Layer 2, using MAC addresses to forward frames within a LAN.', 'easy', 'approved'),
                $this->q('What is the difference between TCP and UDP?', [$this->correct('TCP is connection-oriented and reliable, UDP is connectionless and faster'), $this->wrong('UDP is more reliable than TCP'), $this->wrong('TCP is faster than UDP'), $this->wrong('They are the same protocol')], 'TCP provides reliable, ordered delivery with error checking, while UDP is faster but doesn\'t guarantee delivery.', 'medium', 'approved'),
            ],
            'Network Access' => [
                $this->q('What is the purpose of Spanning Tree Protocol (STP)?', [$this->correct('To prevent Layer 2 loops in switched networks'), $this->wrong('To route packets between VLANs'), $this->wrong('To assign IP addresses'), $this->wrong('To encrypt traffic')], 'STP prevents loops by blocking redundant paths, ensuring only one active path exists between switches.', 'medium', 'approved'),
                $this->q('What is a trunk port in a switch?', [$this->correct('A port that carries traffic for multiple VLANs'), $this->wrong('A port connected to a router'), $this->wrong('A port with the highest bandwidth'), $this->wrong('A port that is disabled')], 'Trunk ports carry traffic for multiple VLANs, typically using 802.1Q tagging to identify VLAN membership.', 'medium', 'approved'),
                $this->q('What does the "switchport mode access" command do?', [$this->correct('Configures the port to belong to a single VLAN'), $this->wrong('Enables trunking on the port'), $this->wrong('Disables the port'), $this->wrong('Enables port security')], 'Access mode configures a switch port to belong to a single VLAN, typically used for end devices.', 'easy', 'approved'),
            ],
            'IP Connectivity' => [
                $this->q('What is the administrative distance of a directly connected route?', [$this->correct('0'), $this->wrong('1'), $this->wrong('90'), $this->wrong('110')], 'Directly connected routes have an AD of 0, making them the most trusted. Static routes have AD 1, EIGRP 90, OSPF 110.', 'medium', 'approved'),
                $this->q('What routing protocol uses the Dijkstra algorithm?', [$this->correct('OSPF'), $this->wrong('RIP'), $this->wrong('EIGRP'), $this->wrong('BGP')], 'OSPF uses Dijkstra\'s Shortest Path First (SPF) algorithm to calculate the best path to each destination.', 'medium', 'approved'),
                $this->q('What is the purpose of a default route?', [$this->correct('To route packets when no specific route exists in the routing table'), $this->wrong('To route packets within the same subnet'), $this->wrong('To block all traffic'), $this->wrong('To enable DHCP')], 'A default route (0.0.0.0/0) is used when no specific route matches the destination, typically pointing to the ISP.', 'easy', 'approved'),
            ],
            'IP Services' => [
                $this->q('What is NAT?', [$this->correct('Network Address Translation - translates private IPs to public IPs'), $this->wrong('Network Access Technology'), $this->wrong('New Address Transfer'), $this->wrong('Network Authentication Tool')], 'NAT translates private IP addresses to public IP addresses, allowing multiple devices to share a single public IP.', 'easy', 'approved'),
                $this->q('What is the difference between DHCP relay and DHCP server?', [$this->correct('DHCP relay forwards DHCP requests to a remote DHCP server'), $this->wrong('They are the same thing'), $this->wrong('DHCP relay assigns IP addresses directly'), $this->wrong('DHCP server forwards requests')], 'A DHCP relay agent forwards DHCP broadcasts to a DHCP server on a different subnet, since broadcasts don\'t cross routers.', 'medium', 'approved'),
                $this->q('What protocol does NTP use?', [$this->correct('UDP port 123'), $this->wrong('TCP port 123'), $this->wrong('UDP port 161'), $this->wrong('TCP port 80')], 'NTP (Network Time Protocol) uses UDP port 123 to synchronize time across network devices.', 'medium', 'approved'),
            ],
            'Security Fundamentals' => [
                $this->q('What is the purpose of an access control list (ACL)?', [$this->correct('To filter traffic based on specified criteria'), $this->wrong('To assign IP addresses'), $this->wrong('To create VLANs'), $this->wrong('To enable routing')], 'ACLs filter traffic based on source/destination IP, port numbers, and protocols to control network access.', 'easy', 'approved'),
                $this->q('What is port security on a switch?', [$this->correct('A feature that limits which devices can connect to a switch port'), $this->wrong('A feature that blocks all ports'), $this->wrong('A feature that enables trunking'), $this->wrong('A feature that assigns VLANs')], 'Port security restricts which MAC addresses can connect to a switch port, preventing unauthorized access.', 'medium', 'approved'),
                $this->q('What is the difference between SSH and Telnet?', [$this->correct('SSH is encrypted, Telnet sends data in clear text'), $this->wrong('Telnet is more secure than SSH'), $this->wrong('They use the same port'), $this->wrong('SSH is slower than Telnet')], 'SSH (port 22) encrypts all traffic including passwords, while Telnet (port 23) sends everything in clear text.', 'easy', 'approved'),
            ],
            'Automation and Programmability' => [
                $this->q('What is the purpose of REST APIs in network automation?', [$this->correct('To allow programmatic access to network devices using HTTP methods'), $this->wrong('To replace CLI access'), $this->wrong('To encrypt network traffic'), $this->wrong('To assign IP addresses')], 'REST APIs enable network automation by allowing scripts and applications to configure and monitor devices using HTTP methods (GET, POST, PUT, DELETE).', 'medium', 'approved'),
                $this->q('What data format is commonly used with REST APIs?', [$this->correct('JSON'), $this->wrong('Binary'), $this->wrong('Plain text'), $this->wrong('Hexadecimal')], 'JSON (JavaScript Object Notation) is the most common data format for REST APIs due to its readability and ease of parsing.', 'easy', 'approved'),
                $this->q('What is the purpose of configuration management tools like Ansible?', [$this->correct('To automate configuration of multiple network devices'), $this->wrong('To monitor network traffic'), $this->wrong('To encrypt data'), $this->wrong('To assign IP addresses')], 'Configuration management tools automate the deployment and management of configurations across multiple devices, ensuring consistency.', 'medium', 'approved'),
            ],
        ];
    }
}

