# On-Premise Load Balancer & High Availability

## Overview

This project focuses on the design and implementation of an **on-premise load balancing solution** using HAProxy to improve the performance, reliability and high availability of a web application.

The infrastructure consists of a dedicated load balancer and two backend web servers deployed on virtual machines.

## Objectives

* Distribute incoming HTTP traffic between multiple backend servers
* Improve application availability and performance
* Detect backend server failures
* Redirect traffic to available servers
* Monitor load balancer activity and server health

## Architecture

```text
                         Client
                           │
                           ▼
                    HAProxy Load Balancer
                        172.0.1.40
                           │
                    Round Robin
                     /         \
                    ▼           ▼
                Web1            Web2
             172.0.1.41      172.0.1.42
                    \           /
                     \         /
                       Database
```

## Load Balancing

HAProxy was configured using the **Round Robin** algorithm to distribute HTTP requests between the two backend web servers.

Health checks were implemented to monitor server availability and prevent traffic from being sent to an unavailable server.

## Web Application

The project includes a web application developed using:

* PHP
* HTML
* CSS
* MySQL
* Apache

The application was deployed on both backend servers.

## Monitoring & Testing

HAProxy statistics were used to monitor:

* Active connections
* Traffic
* Requests
* Errors
* Backend server status
* Server health checks

Tests were performed under normal conditions and in the event of a backend server failure.

## Technologies

* HAProxy
* Apache
* PHP
* MySQL
* Linux
* Virtual Machines
* HTML / CSS

```

>  Confidential information, credentials and sensitive company data are not included in this repository.

