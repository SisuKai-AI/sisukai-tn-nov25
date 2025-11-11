<?php

namespace Database\Seeders\Questions;

class OracleCertifiedProfessionalJavaSEProgrammerQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'oracle-java-se-programmer';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Java Basics' => [
                $this->q('What is the main method signature in Java?', [$this->correct('public static void main(String[] args)'), $this->wrong('public void main(String[] args)'), $this->wrong('static void main(String args)'), $this->wrong('public main(String[] args)')], 'The main method must be public, static, void, and accept a String array parameter to serve as the program entry point.', 'easy', 'approved'),
                $this->q('What is the difference between JDK and JRE?', [$this->correct('JDK includes development tools, JRE only runs Java applications'), $this->wrong('They are the same'), $this->wrong('JRE is for development, JDK is for running'), $this->wrong('JDK is smaller than JRE')], 'JDK (Java Development Kit) includes compiler and tools for development, while JRE (Java Runtime Environment) only runs Java applications.', 'easy', 'approved'),
                $this->q('What is bytecode in Java?', [$this->correct('Platform-independent intermediate code executed by the JVM'), $this->wrong('Source code'), $this->wrong('Machine code'), $this->wrong('Assembly code')], 'Java source code compiles to bytecode (.class files), which the JVM interprets, enabling "write once, run anywhere".', 'medium', 'approved'),
            ],
            'Object-Oriented Programming' => [
                $this->q('What is encapsulation?', [$this->correct('Bundling data and methods together and hiding internal details'), $this->wrong('Creating multiple classes'), $this->wrong('Inheriting from parent classes'), $this->wrong('Implementing interfaces')], 'Encapsulation bundles data (fields) and methods together in a class and restricts direct access to some components using access modifiers.', 'easy', 'approved'),
                $this->q('What is the difference between abstract class and interface?', [$this->correct('Abstract classes can have implementation, interfaces (pre-Java 8) cannot'), $this->wrong('They are the same'), $this->wrong('Interfaces can have constructors'), $this->wrong('Abstract classes cannot have methods')], 'Abstract classes can have both abstract and concrete methods, while interfaces (before Java 8) could only declare methods without implementation.', 'medium', 'approved'),
                $this->q('What is polymorphism?', [$this->correct('The ability of objects to take multiple forms'), $this->wrong('Creating multiple objects'), $this->wrong('Using multiple classes'), $this->wrong('Implementing multiple interfaces')], 'Polymorphism allows objects of different classes to be treated as objects of a common superclass, enabling method overriding and overloading.', 'medium', 'approved'),
            ],
            'Collections Framework' => [
                $this->q('What is the difference between ArrayList and LinkedList?', [$this->correct('ArrayList uses array, LinkedList uses doubly-linked nodes'), $this->wrong('They are the same'), $this->wrong('LinkedList is always faster'), $this->wrong('ArrayList cannot grow')], 'ArrayList provides fast random access but slow insertions/deletions, while LinkedList is efficient for insertions/deletions but slower for random access.', 'medium', 'approved'),
                $this->q('What is a HashMap?', [$this->correct('A collection that stores key-value pairs'), $this->wrong('A list of values'), $this->wrong('An array'), $this->wrong('A set of unique values')], 'HashMap stores data in key-value pairs, providing fast retrieval based on keys using hashing.', 'easy', 'approved'),
                $this->q('What is the difference between Set and List?', [$this->correct('Set stores unique elements, List allows duplicates'), $this->wrong('They are the same'), $this->wrong('List stores unique elements'), $this->wrong('Set maintains insertion order')], 'Set collections (HashSet, TreeSet) store unique elements, while List collections (ArrayList, LinkedList) allow duplicates and maintain order.', 'easy', 'approved'),
            ],
            'Exception Handling' => [
                $this->q('What is the difference between checked and unchecked exceptions?', [$this->correct('Checked must be caught or declared, unchecked do not'), $this->wrong('They are the same'), $this->wrong('Unchecked must be caught'), $this->wrong('Checked are runtime exceptions')], 'Checked exceptions (IOException, SQLException) must be caught or declared, while unchecked exceptions (RuntimeException subclasses) do not require explicit handling.', 'medium', 'approved'),
                $this->q('What is the purpose of the finally block?', [$this->correct('To execute code regardless of whether an exception occurred'), $this->wrong('To catch exceptions'), $this->wrong('To throw exceptions'), $this->wrong('To declare exceptions')], 'The finally block always executes after try-catch, typically used for cleanup operations like closing resources.', 'easy', 'approved'),
                $this->q('What is try-with-resources?', [$this->correct('Automatic resource management that closes resources after use'), $this->wrong('A way to catch multiple exceptions'), $this->wrong('A method to throw exceptions'), $this->wrong('A type of loop')], 'Try-with-resources automatically closes resources that implement AutoCloseable, eliminating the need for explicit finally blocks.', 'medium', 'approved'),
            ],
            'Concurrency' => [
                $this->q('What is a thread in Java?', [$this->correct('A lightweight subprocess for concurrent execution'), $this->wrong('A data structure'), $this->wrong('A collection type'), $this->wrong('An exception type')], 'Threads enable concurrent execution within a program, allowing multiple tasks to run simultaneously.', 'easy', 'approved'),
                $this->q('What is the difference between synchronized and volatile?', [$this->correct('Synchronized provides mutual exclusion, volatile ensures visibility'), $this->wrong('They are the same'), $this->wrong('Volatile is stronger than synchronized'), $this->wrong('Synchronized is deprecated')], 'Synchronized provides mutual exclusion (only one thread at a time), while volatile ensures variable changes are visible to all threads.', 'medium', 'approved'),
                $this->q('What is a deadlock?', [$this->correct('When two or more threads are blocked forever, waiting for each other'), $this->wrong('When a thread stops running'), $this->wrong('When a program crashes'), $this->wrong('When memory runs out')], 'Deadlock occurs when threads hold locks and wait for locks held by other threads, creating a circular dependency.', 'medium', 'approved'),
            ],
        ];
    }
}

