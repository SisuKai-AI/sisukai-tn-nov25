<?php

namespace Database\Seeders\Questions;

class MicrosoftCertifiedAzureDataFundamentalsDP900QuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'microsoft-azure-data-fundamentals-dp-900';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Core Data Concepts' => [
                $this->q('What is structured data?', [$this->correct('Data organized in a defined format like tables with rows and columns'), $this->wrong('Unorganized data without schema'), $this->wrong('Video and audio files'), $this->wrong('Social media posts')], 'Structured data follows a fixed schema, typically stored in relational databases with tables, rows, and columns.', 'easy', 'approved'),
                $this->q('What is the difference between relational and non-relational databases?', [$this->correct('Relational uses tables with relationships, non-relational uses flexible schemas'), $this->wrong('They are the same'), $this->wrong('Non-relational is always faster'), $this->wrong('Relational cannot scale')], 'Relational databases use structured tables with defined relationships, while non-relational (NoSQL) databases use flexible schemas like documents or key-value pairs.', 'medium', 'approved'),
                $this->q('What does OLTP stand for?', [$this->correct('Online Transaction Processing'), $this->wrong('Online Transfer Protocol'), $this->wrong('Optimized Long-Term Processing'), $this->wrong('Operational Load Testing Platform')], 'OLTP systems handle high volumes of short transactions (inserts, updates, deletes) in real-time, like banking or e-commerce systems.', 'easy', 'approved'),
            ],
            'Relational Data in Azure' => [
                $this->q('What is Azure SQL Database?', [$this->correct('A fully managed relational database service'), $this->wrong('A NoSQL database'), $this->wrong('A file storage service'), $this->wrong('A virtual machine')], 'Azure SQL Database is a PaaS offering providing a fully managed SQL Server database engine in the cloud.', 'easy', 'approved'),
                $this->q('What is the difference between Azure SQL Database and SQL Server on Azure VMs?', [$this->correct('SQL Database is PaaS (managed), SQL on VMs is IaaS (you manage)'), $this->wrong('They are the same'), $this->wrong('SQL on VMs is always cheaper'), $this->wrong('SQL Database cannot scale')], 'Azure SQL Database is fully managed (PaaS), while SQL Server on VMs gives you full control but requires management (IaaS).', 'medium', 'approved'),
                $this->q('What is a primary key?', [$this->correct('A unique identifier for each row in a table'), $this->wrong('The first column in a table'), $this->wrong('A password for the database'), $this->wrong('An encryption key')], 'A primary key uniquely identifies each record in a table and cannot contain NULL values.', 'easy', 'approved'),
            ],
            'Non-Relational Data in Azure' => [
                $this->q('What is Azure Cosmos DB?', [$this->correct('A globally distributed, multi-model NoSQL database'), $this->wrong('A relational database'), $this->wrong('A file storage service'), $this->wrong('A virtual machine')], 'Azure Cosmos DB is a fully managed NoSQL database supporting multiple data models (document, key-value, graph, column-family).', 'easy', 'approved'),
                $this->q('What is Azure Table Storage?', [$this->correct('A NoSQL key-value store for structured data'), $this->wrong('A relational database'), $this->wrong('A file system'), $this->wrong('A queue service')], 'Azure Table Storage stores structured NoSQL data in the cloud, providing a key/attribute store with schemaless design.', 'medium', 'approved'),
                $this->q('What is Azure Blob Storage used for?', [$this->correct('Storing unstructured data like documents, images, and videos'), $this->wrong('Storing relational data'), $this->wrong('Running virtual machines'), $this->wrong('Hosting websites only')], 'Azure Blob Storage is optimized for storing massive amounts of unstructured data like text, binary data, images, and videos.', 'easy', 'approved'),
            ],
            'Analytics Workloads in Azure' => [
                $this->q('What is Azure Synapse Analytics?', [$this->correct('An analytics service for big data and data warehousing'), $this->wrong('A NoSQL database'), $this->wrong('A file storage service'), $this->wrong('A machine learning platform')], 'Azure Synapse Analytics combines big data and data warehousing, enabling analytics on large volumes of data.', 'medium', 'approved'),
                $this->q('What is the difference between OLTP and OLAP?', [$this->correct('OLTP handles transactions, OLAP handles analytics'), $this->wrong('They are the same'), $this->wrong('OLAP is faster for transactions'), $this->wrong('OLTP is better for analytics')], 'OLTP (Online Transaction Processing) handles day-to-day transactions, while OLAP (Online Analytical Processing) handles complex queries for analytics.', 'medium', 'approved'),
                $this->q('What is Azure Data Lake Storage?', [$this->correct('A scalable data lake for big data analytics'), $this->wrong('A relational database'), $this->wrong('A NoSQL database'), $this->wrong('A virtual machine')], 'Azure Data Lake Storage is a massively scalable and secure data lake for high-performance analytics workloads.', 'easy', 'approved'),
            ],
        ];
    }
}

