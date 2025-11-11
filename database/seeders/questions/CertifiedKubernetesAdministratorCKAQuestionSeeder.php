<?php

namespace Database\Seeders\Questions;

class CertifiedKubernetesAdministratorCKAQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'certified-kubernetes-administrator-cka';
    }

    protected function getQuestionsData(): array
    {
        return [
            // Domain 1: Cluster Architecture, Installation & Configuration
            'Kubernetes Architecture' => [
                $this->q(
                    'What is the role of the kube-apiserver?',
                    [
                        $this->correct('It exposes the Kubernetes API and is the front-end for the Kubernetes control plane'),
                        $this->wrong('It schedules pods to nodes'),
                        $this->wrong('It stores cluster data'),
                        $this->wrong('It runs containers'),
                    ],
                    'The kube-apiserver is the front-end for the Kubernetes control plane. It exposes the Kubernetes API and processes REST operations.',
                    'easy', 'approved'),
                $this->q(
                    'Which component is responsible for scheduling pods to nodes?',
                    [
                        $this->correct('kube-scheduler'),
                        $this->wrong('kube-apiserver'),
                        $this->wrong('kube-controller-manager'),
                        $this->wrong('kubelet'),
                    ],
                    'The kube-scheduler watches for newly created pods with no assigned node and selects a node for them to run on.',
                    'easy', 'approved'),
                $this->q(
                    'What is etcd in Kubernetes?',
                    [
                        $this->correct('A distributed key-value store that holds the cluster state'),
                        $this->wrong('A container runtime'),
                        $this->wrong('A load balancer'),
                        $this->wrong('A monitoring tool'),
                    ],
                    'etcd is a consistent and highly-available key-value store used as Kubernetes\' backing store for all cluster data.',
                    'medium', 'approved'),
            ],

            'Cluster Installation' => [
                $this->q(
                    'Which tool is commonly used to bootstrap a Kubernetes cluster?',
                    [
                        $this->correct('kubeadm'),
                        $this->wrong('kubectl'),
                        $this->wrong('kubelet'),
                        $this->wrong('kube-proxy'),
                    ],
                    'kubeadm is a tool built to provide best-practice "fast paths" for creating Kubernetes clusters.',
                    'easy', 'approved'),
                $this->q(
                    'What is the minimum number of nodes required for a highly available Kubernetes cluster?',
                    [
                        $this->correct('3 control plane nodes'),
                        $this->wrong('1 control plane node'),
                        $this->wrong('2 control plane nodes'),
                        $this->wrong('5 control plane nodes'),
                    ],
                    'For high availability, you need at least 3 control plane nodes to maintain quorum in etcd and handle failures.',
                    'medium', 'approved'),
                $this->q(
                    'What is the purpose of kubelet?',
                    [
                        $this->correct('An agent that runs on each node and ensures containers are running in pods'),
                        $this->wrong('A tool for managing cluster configuration'),
                        $this->wrong('A network proxy'),
                        $this->wrong('A storage provisioner'),
                    ],
                    'The kubelet is the primary node agent that runs on each node, ensuring that containers are running in a pod.',
                    'easy', 'approved'),
            ],

            'RBAC and Security' => [
                $this->q(
                    'What does RBAC stand for in Kubernetes?',
                    [
                        $this->correct('Role-Based Access Control'),
                        $this->wrong('Resource-Based Access Control'),
                        $this->wrong('Rule-Based Access Control'),
                        $this->wrong('Remote-Based Access Control'),
                    ],
                    'RBAC (Role-Based Access Control) is a method of regulating access to resources based on the roles of individual users within an organization.',
                    'easy', 'approved'),
                $this->q(
                    'What is the difference between a Role and a ClusterRole?',
                    [
                        $this->correct('A Role is namespace-scoped while a ClusterRole is cluster-scoped'),
                        $this->wrong('They are the same thing'),
                        $this->wrong('A ClusterRole is namespace-scoped while a Role is cluster-scoped'),
                        $this->wrong('ClusterRole is deprecated'),
                    ],
                    'Roles are namespace-scoped and grant permissions within a specific namespace, while ClusterRoles are cluster-scoped and can grant permissions across all namespaces.',
                    'medium', 'approved'),
                $this->q(
                    'What is a ServiceAccount in Kubernetes?',
                    [
                        $this->correct('An identity for processes running in pods'),
                        $this->wrong('An account for human users'),
                        $this->wrong('A network service'),
                        $this->wrong('A storage account'),
                    ],
                    'ServiceAccounts provide an identity for processes that run in a pod, allowing them to interact with the Kubernetes API.',
                    'medium', 'approved'),
            ],

            'Networking Fundamentals' => [
                $this->q(
                    'What is a Service in Kubernetes?',
                    [
                        $this->correct('An abstraction that defines a logical set of pods and a policy to access them'),
                        $this->wrong('A physical server'),
                        $this->wrong('A container image'),
                        $this->wrong('A storage volume'),
                    ],
                    'A Service is an abstract way to expose an application running on a set of pods as a network service.',
                    'easy', 'approved'),
                $this->q(
                    'What type of Service exposes pods to external traffic with a cloud provider load balancer?',
                    [
                        $this->correct('LoadBalancer'),
                        $this->wrong('ClusterIP'),
                        $this->wrong('NodePort'),
                        $this->wrong('ExternalName'),
                    ],
                    'LoadBalancer service type exposes the service externally using a cloud provider\'s load balancer.',
                    'easy', 'approved'),
                $this->q(
                    'What is the default Service type in Kubernetes?',
                    [
                        $this->correct('ClusterIP'),
                        $this->wrong('NodePort'),
                        $this->wrong('LoadBalancer'),
                        $this->wrong('ExternalName'),
                    ],
                    'ClusterIP is the default Service type, which exposes the service on an internal IP within the cluster.',
                    'medium', 'approved'),
            ],

            // Domain 2: Workloads & Scheduling
            'Pods and Deployments' => [
                $this->q(
                    'What is a Pod in Kubernetes?',
                    [
                        $this->correct('The smallest deployable unit that can contain one or more containers'),
                        $this->wrong('A physical server'),
                        $this->wrong('A virtual machine'),
                        $this->wrong('A storage volume'),
                    ],
                    'A Pod is the smallest deployable unit in Kubernetes and can contain one or more containers that share storage and network resources.',
                    'easy', 'approved'),
                $this->q(
                    'What is a Deployment in Kubernetes?',
                    [
                        $this->correct('A resource that manages a replicated application and provides declarative updates'),
                        $this->wrong('A single pod'),
                        $this->wrong('A network service'),
                        $this->wrong('A storage class'),
                    ],
                    'A Deployment provides declarative updates for pods and ReplicaSets, managing the desired state of your application.',
                    'easy', 'approved'),
                $this->q(
                    'What is the purpose of a ReplicaSet?',
                    [
                        $this->correct('To maintain a stable set of replica pods running at any given time'),
                        $this->wrong('To store data'),
                        $this->wrong('To route network traffic'),
                        $this->wrong('To schedule jobs'),
                    ],
                    'A ReplicaSet ensures that a specified number of pod replicas are running at any given time.',
                    'medium', 'approved'),
            ],

            'ConfigMaps and Secrets' => [
                $this->q(
                    'What is a ConfigMap?',
                    [
                        $this->correct('An object used to store non-confidential configuration data in key-value pairs'),
                        $this->wrong('A tool for managing secrets'),
                        $this->wrong('A network configuration'),
                        $this->wrong('A storage volume'),
                    ],
                    'ConfigMaps allow you to decouple configuration artifacts from image content to keep containerized applications portable.',
                    'easy', 'approved'),
                $this->q(
                    'What is the difference between a ConfigMap and a Secret?',
                    [
                        $this->correct('Secrets are intended for sensitive data while ConfigMaps are for non-sensitive configuration'),
                        $this->wrong('They are exactly the same'),
                        $this->wrong('ConfigMaps are encrypted, Secrets are not'),
                        $this->wrong('Secrets are larger than ConfigMaps'),
                    ],
                    'Secrets are intended to hold sensitive information like passwords and tokens, while ConfigMaps hold non-sensitive configuration data.',
                    'medium', 'approved'),
                $this->q(
                    'How are Secrets stored in etcd by default?',
                    [
                        $this->correct('Base64 encoded (not encrypted by default)'),
                        $this->wrong('Fully encrypted'),
                        $this->wrong('Plain text'),
                        $this->wrong('Hashed'),
                    ],
                    'By default, Secrets are stored in etcd as base64-encoded strings, not encrypted. Encryption at rest must be configured separately.',
                    'medium', 'approved'),
            ],

            'Resource Management' => [
                $this->q(
                    'What is the difference between resource requests and limits?',
                    [
                        $this->correct('Requests are guaranteed resources, limits are maximum resources a container can use'),
                        $this->wrong('They are the same thing'),
                        $this->wrong('Limits are guaranteed, requests are maximum'),
                        $this->wrong('Neither affects scheduling'),
                    ],
                    'Resource requests specify the minimum amount of resources guaranteed to a container, while limits specify the maximum amount it can use.',
                    'medium', 'approved'),
                $this->q(
                    'What happens when a pod exceeds its memory limit?',
                    [
                        $this->correct('The pod is terminated (OOMKilled)'),
                        $this->wrong('Nothing happens'),
                        $this->wrong('The pod gets more memory automatically'),
                        $this->wrong('The pod is moved to another node'),
                    ],
                    'When a container exceeds its memory limit, it is terminated with an OOMKilled (Out Of Memory Killed) status.',
                    'medium', 'approved'),
            ],

            'Scheduling' => [
                $this->q(
                    'What is a node selector?',
                    [
                        $this->correct('A field in the pod spec that constrains pods to nodes with specific labels'),
                        $this->wrong('A tool for selecting container images'),
                        $this->wrong('A network routing rule'),
                        $this->wrong('A storage selector'),
                    ],
                    'Node selectors allow you to constrain which nodes your pod can be scheduled on based on node labels.',
                    'easy', 'approved'),
                $this->q(
                    'What is a taint in Kubernetes?',
                    [
                        $this->correct('A property of nodes that repels pods unless they have matching tolerations'),
                        $this->wrong('A type of pod'),
                        $this->wrong('A network policy'),
                        $this->wrong('A storage class'),
                    ],
                    'Taints allow a node to repel a set of pods. Tolerations are applied to pods and allow them to schedule onto nodes with matching taints.',
                    'medium', 'approved'),
            ],

            // Domain 3: Services & Networking
            'Ingress' => [
                $this->q(
                    'What is an Ingress in Kubernetes?',
                    [
                        $this->correct('An API object that manages external access to services, typically HTTP/HTTPS'),
                        $this->wrong('A type of pod'),
                        $this->wrong('A storage volume'),
                        $this->wrong('A container runtime'),
                    ],
                    'Ingress exposes HTTP and HTTPS routes from outside the cluster to services within the cluster.',
                    'easy', 'approved'),
                $this->q(
                    'What is required for Ingress to work?',
                    [
                        $this->correct('An Ingress controller must be running in the cluster'),
                        $this->wrong('Nothing, it works by default'),
                        $this->wrong('Only the Ingress resource definition'),
                        $this->wrong('A LoadBalancer service'),
                    ],
                    'An Ingress controller is required to fulfill Ingress resources. Simply creating an Ingress resource has no effect without a controller.',
                    'medium', 'approved'),
            ],

            'Network Policies' => [
                $this->q(
                    'What is a NetworkPolicy?',
                    [
                        $this->correct('A specification of how groups of pods are allowed to communicate with each other'),
                        $this->wrong('A firewall configuration'),
                        $this->wrong('A load balancing rule'),
                        $this->wrong('A DNS configuration'),
                    ],
                    'NetworkPolicies are specifications of how groups of pods are allowed to communicate with each other and other network endpoints.',
                    'medium', 'approved'),
                $this->q(
                    'By default, what is the network policy for pods?',
                    [
                        $this->correct('All pods can communicate with all other pods'),
                        $this->wrong('All traffic is blocked'),
                        $this->wrong('Only same-namespace communication is allowed'),
                        $this->wrong('No network access'),
                    ],
                    'By default, pods are non-isolated and accept traffic from any source. NetworkPolicies must be created to restrict traffic.',
                    'easy', 'approved'),
            ],

            'DNS and Service Discovery' => [
                $this->q(
                    'What is CoreDNS in Kubernetes?',
                    [
                        $this->correct('The default DNS server for Kubernetes clusters'),
                        $this->wrong('A container runtime'),
                        $this->wrong('A storage plugin'),
                        $this->wrong('A monitoring tool'),
                    ],
                    'CoreDNS is a flexible, extensible DNS server that serves as the default DNS server for Kubernetes clusters.',
                    'easy', 'approved'),
                $this->q(
                    'What is the DNS name format for a service in Kubernetes?',
                    [
                        $this->correct('<service-name>.<namespace>.svc.cluster.local'),
                        $this->wrong('<service-name>.cluster.local'),
                        $this->wrong('<namespace>.<service-name>'),
                        $this->wrong('<service-name>'),
                    ],
                    'Services are assigned DNS names in the format: <service-name>.<namespace>.svc.cluster.local',
                    'medium', 'approved'),
            ],

            // Domain 4: Storage
            'Persistent Volumes' => [
                $this->q(
                    'What is a PersistentVolume (PV)?',
                    [
                        $this->correct('A piece of storage in the cluster provisioned by an administrator or dynamically'),
                        $this->wrong('A temporary storage in a pod'),
                        $this->wrong('A container image'),
                        $this->wrong('A network volume'),
                    ],
                    'A PersistentVolume (PV) is a piece of storage in the cluster that has been provisioned by an administrator or dynamically using Storage Classes.',
                    'easy', 'approved'),
                $this->q(
                    'What is a PersistentVolumeClaim (PVC)?',
                    [
                        $this->correct('A request for storage by a user'),
                        $this->wrong('A type of storage'),
                        $this->wrong('A container'),
                        $this->wrong('A network policy'),
                    ],
                    'A PersistentVolumeClaim (PVC) is a request for storage by a user. It is similar to a pod requesting CPU and memory resources.',
                    'easy', 'approved'),
                $this->q(
                    'What is the default reclaim policy for dynamically provisioned PersistentVolumes?',
                    [
                        $this->correct('Delete'),
                        $this->wrong('Retain'),
                        $this->wrong('Recycle'),
                        $this->wrong('Archive'),
                    ],
                    'The default reclaim policy for dynamically provisioned PersistentVolumes is Delete, which deletes the volume when the PVC is deleted.',
                    'medium', 'approved'),
            ],

            'Storage Classes' => [
                $this->q(
                    'What is a StorageClass?',
                    [
                        $this->correct('A way to describe different types of storage available in the cluster'),
                        $this->wrong('A type of pod'),
                        $this->wrong('A network configuration'),
                        $this->wrong('A container runtime'),
                    ],
                    'A StorageClass provides a way for administrators to describe the "classes" of storage they offer, enabling dynamic provisioning.',
                    'medium', 'approved'),
            ],

            // Domain 5: Troubleshooting
            'Debugging' => [
                $this->q(
                    'Which command shows the logs of a pod?',
                    [
                        $this->correct('kubectl logs <pod-name>'),
                        $this->wrong('kubectl describe pod <pod-name>'),
                        $this->wrong('kubectl get pod <pod-name>'),
                        $this->wrong('kubectl exec <pod-name>'),
                    ],
                    'kubectl logs retrieves logs from a container in a pod.',
                    'easy', 'approved'),
                $this->q(
                    'Which command provides detailed information about a resource?',
                    [
                        $this->correct('kubectl describe'),
                        $this->wrong('kubectl get'),
                        $this->wrong('kubectl logs'),
                        $this->wrong('kubectl exec'),
                    ],
                    'kubectl describe shows detailed information about a specific resource, including events.',
                    'easy', 'approved'),
                $this->q(
                    'How do you execute a command inside a running container?',
                    [
                        $this->correct('kubectl exec -it <pod-name> -- <command>'),
                        $this->wrong('kubectl run <command>'),
                        $this->wrong('kubectl logs <pod-name>'),
                        $this->wrong('kubectl describe <pod-name>'),
                    ],
                    'kubectl exec allows you to execute commands in a container. The -it flags provide an interactive terminal.',
                    'medium', 'approved'),
            ],

            'Cluster Troubleshooting' => [
                $this->q(
                    'Where are kubelet logs typically stored on a node?',
                    [
                        $this->correct('/var/log/kubelet.log or via journalctl'),
                        $this->wrong('/etc/kubernetes/kubelet.log'),
                        $this->wrong('/home/kubelet.log'),
                        $this->wrong('/tmp/kubelet.log'),
                    ],
                    'Kubelet logs are typically found in /var/log/kubelet.log or can be viewed using journalctl -u kubelet on systemd-based systems.',
                    'medium', 'approved'),
                $this->q(
                    'What does the "ImagePullBackOff" status indicate?',
                    [
                        $this->correct('Kubernetes cannot pull the container image'),
                        $this->wrong('The pod is running successfully'),
                        $this->wrong('The pod has been deleted'),
                        $this->wrong('The node is down'),
                    ],
                    'ImagePullBackOff indicates that Kubernetes is unable to pull the container image, often due to incorrect image names, missing credentials, or network issues.',
                    'easy', 'approved'),
            ],
        ];
    }
}

