# Multi-Tenant RBAC SaaS – Academy ERP

A backend-focused SaaS application implementing Role-Based Access Control (RBAC) with tenant isolation, permission mapping and admission billing system.

This project simulates a real organization workspace where each tenant (owner) manages users, roles and admissions independently with secure access control.

---

## Key Features

### Authentication & Authorization

* Secure login using PHP sessions
* Owner auto-created during first registration
* Middleware-based permission validation
* Direct permission + role permission support

### Multi-Tenant Architecture

* Owner-scoped data isolation
* Users belong to specific tenant workspace
* Roles separated per tenant
* Cross-tenant access prevention

### Role & Permission System

* Create custom roles (Manager, Staff, Accountant)
* Assign permissions to roles
* Assign roles to users
* Override role permissions using direct permission

### Admission & Billing Module

* Admission form with dynamic GST calculation
* CGST / SGST / IGST support
* Automatic fee calculation
* Printable receipt & PDF download

---

## Database Architecture

Core tables:

users
roles
permissions
user_roles
role_permissions
user_permissions
admissions

Implements many-to-many mapping between users, roles and permissions.

---

## Tech Stack

Backend: PHP
Database: MySQL
Frontend: HTML, CSS, Bootstrap, JavaScript

---

## How Access Control Works

1. User logs in
2. System fetches role permissions
3. System merges direct permissions
4. Middleware validates permission before page render
5. Unauthorized users blocked

---

## Project Purpose

Built to demonstrate real-world backend concepts:

* Authorization architecture
* Multi-tenant design
* Secure session management
* Relational database modeling
* Middleware access control

---

## Future Improvements

* JWT authentication
* REST API version
* Audit logs
* Activity tracking
