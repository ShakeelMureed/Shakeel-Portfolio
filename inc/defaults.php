<?php
if (!defined('ABSPATH')) { exit; }

function smp_theme_defaults(): array {
    return [
        'hero_eyebrow' => 'Magento 2 · Hyvä · PHP · Multi-store Commerce',
        'hero_title' => 'Senior Magento 2 developer for complex commerce and reliable delivery.',
        'hero_highlight' => 'complex commerce',
        'hero_lead' => 'I’m Shakeel Mureed, a Senior Magento 2 and e-commerce developer helping teams build custom modules, modernize Hyvä storefronts and maintain business-critical multi-store platforms.',
        'hero_primary_label' => 'View My Work', 'hero_secondary_label' => 'Download Resume',
        'proof_one' => '13+ years web & frontend', 'proof_two' => '8+ years Magento 2', 'proof_three' => 'Lahore · Available remotely',
        'about_heading' => 'Magento engineering grounded in frontend craftsmanship.',
        'about_lead' => 'I translate complex commerce requirements into maintainable, tested solutions.',
        'about_body' => 'My work covers Magento 2 custom modules, Hyvä storefronts, PHP, MySQL, REST APIs, checkout, customer accounts, multi-store architecture and production troubleshooting.\n\nI can trace a storefront problem through templates, services, collections and data, implement the right change, and validate the complete customer journey. I also bring extensive WordPress and WooCommerce experience to content-driven and integration-heavy projects.',
        'services_heading' => 'Senior development across the commerce journey.',
        'services_intro' => 'Focused help for a complex feature, platform modernization, difficult production issue or ongoing development.',
        'portfolio_heading' => 'Commerce projects built around real business requirements.',
        'portfolio_intro' => 'Explore the problem, my role, technical approach, technologies and outcome behind each selected project.',
        'modules_heading' => 'Julefabrikken modules and new customer journeys.',
        'modules_intro' => 'A multi-store Magento 2 platform with distinct manager, leader, employee and VIP workflows across five live storefronts.',
        'experience_heading' => 'Deep Magento practice with full-stack delivery experience.',
        'experience_intro' => 'Eight-plus years specializing in Magento 2, supported by long-term frontend, WordPress and broader web-development experience.',
        'contact_heading' => 'Let’s discuss your Magento or e-commerce requirement.',
        'contact_intro' => 'Available for remote roles, contract work and selected freelance projects.',
        'contact_email' => 'shakeel.mureed52@gmail.com', 'contact_phone' => '+92 315 0673112',
        'contact_location' => 'Lahore, Punjab, Pakistan', 'linkedin_url' => 'https://www.linkedin.com/in/shakeel-mureed-70301276',
        'footer_text' => 'Senior Magento 2 and e-commerce development focused on stable systems, maintainable code and better customer journeys.',
    ];
}

function smp_default_services(): array { return [
 ['Magento 2 Development','Custom modules, customer and admin workflows, checkout, catalog, multi-store logic and upgrade-compatible development.','Custom business logic\nCart and checkout\nCustomer accounts'],
 ['Hyvä & Performance','Modern Magento storefront development using Hyvä, Tailwind CSS and Alpine.js.','Hyvä components\nLuma migration\nFrontend optimization'],
 ['Modules & Integrations','Maintainable connections, data processes and operational workflows for Magento.','REST APIs\nAdmin configuration\nBatch processes'],
 ['Technical Troubleshooting','Structured investigation across Magento reports, SQL, EAV, caching and custom modules.','Error analysis\nProduct collections\nUpgrade compatibility'],
 ['WordPress & WooCommerce','Custom themes, plugins, responsive experiences, integrations and maintenance.','Custom development\nWooCommerce\nPerformance'],
 ['Ongoing Support','Requirement review, reliable feature delivery, regression testing and documentation.','Sprint delivery\nDeployment support\nClear documentation'],
]; }

function smp_default_experience(): array { return [
 ['Magento 2 Developer','2024–Now','Techscale · 2024–Present','Custom frontend and backend development, multi-store gift workflows, customer authentication, voucher redemption, production troubleshooting and deployment support.'],
 ['Senior Magento / Full-stack Developer','2018–2024','RLTSquare · Jun 2018–Jun 2024','Magento and WordPress delivery for international clients, including custom modules, themes, integrations, checkout, performance and technical leadership.'],
 ['Senior WordPress Developer','2016–2018','Systons · Dec 2016–Jul 2018','End-to-end WordPress websites, custom themes and plugins, responsive implementation and reusable development patterns.'],
]; }

function smp_default_modules(): array { return [
 ['PandiWeb_LoginSystem','Role-aware login and access','Extended customer-specific authentication, department and unit login codes, store-aware redirects, login titles and manager-to-employee relationships.','Dedicated VIP storefront behavior\nReusable store configuration\nParent-manager relationship preservation'],
 ['PandiWeb_GiftManager','Gift selection and communication','Maintained wishlist-style gift selection, employee notification, category visibility and role-specific overview pages across multiple storefronts.','Customer and department gift journeys\nLeader selection on behalf of employees\nSelection validation and change safeguards'],
 ['Techscale_CustomerOtp','Customer verification','Supported OTP-driven account access within the wider login workflow and investigated email, Redis and transport dependencies during operational troubleshooting.','Secure verification workflow\nMulti-store compatibility\nStaging and production support'],
]; }

function smp_default_projects(): array { return [
 ['EGO Shoes Campaign Delivery','Magento 2,Five Stores,Amplience','https://ego.co.uk/','projects/ego-shoes-multistore-campaigns.svg','Supported sale launches across five Magento storefronts for approximately four years, coordinating schedules, promotional layouts, banners, Amplience content and go-live checks.','Coordinated sale schedules across five storefronts.\nUpdated promotional layouts, homepage sections and campaign banners.\nSupported Amplience content and time-sensitive live-sale changes.\nExperience relates to the earlier Magento operation before sales transitioned to a third-party platform.'],
 ['Julefabrikken Gift Platform','Magento 2,Multi-store,Custom Modules','https://julefabrikken.dk/','projects/julefabrikken-gift-platform.svg','Extended a five-store Magento gifting platform with VIP access, unit-based login, voucher redemption, leader gifting and reusable customer workflows.','Extended PandiWeb_LoginSystem and PandiWeb_GiftManager.\nBuilt store-aware account, category, redirect and selection rules.\nDelivered safer batch account creation with validation and exception logging.'],
 ['Hyvä Product Discovery & Upgrade','Magento 2,Hyvä,Debugging','https://www.discountedwheelwarehouse.com/','projects/dww-hyva-product-discovery.svg','Migrated and maintained a high-complexity automotive storefront, resolved conflicting product collections and modernized legacy CMS content.','Traced malformed SQL through EAV attributes and custom layers.\nRestored route ownership for tire-size listing pages.\nRebuilt content with Page Builder and checked upgrade compatibility.'],
 ['National Museum of Qatar','Magento 2,Hyvä,Frontend','https://market.qacreates.com/museums/national-museum-of-qatar','projects/national-museum-qatar-hyva.svg','Translated detailed Figma designs into more than 60 responsive HTML pages, then integrated them into a custom Magento 2 Hyvä theme.','Created reusable Tailwind layouts and Alpine.js interactions.\nConverted approved frontend pages into Magento templates.\nSupported backend integration and responsive quality checks.'],
 ['Guest Coupon Protection','Magento 2,Custom Modules,Checkout','','projects/coreedge-promo-protection.svg','Developed CoreEdge_Promo to prevent repeat guest coupon use by validating customer identity against earlier orders before submission.','Checked email, phone and shipping-address matches.\nRespected the promotion’s configured usage limit.\nBlocked ineligible orders before quote-to-order conversion.'],
 ['Company Contacts & Role Permissions','Magento 2,B2B,REST APIs','','projects/b2b-permissions.svg','Built a Magento B2B module for multiple company contacts with Read Only and Modify permissions enforced across storefront and API requests.','Applied permissions to cart, checkout and account workflows.\nProtected direct and API requests, not only interface controls.\nIncluded administrator override and role-change logging.'],
 ['Rosie Taxicab Booking','WordPress,Custom Plugin,Payments','https://rosietaxicab.com/','projects/rosie-taxicab-wordpress.svg','Built and customized a WordPress booking experience with SMS campaign functionality, air-quality integration and Square payment support.','Developed a custom booking-page plugin.\nConnected operational notifications and third-party services.\nDelivered responsive UI and payment workflow customization.'],
 ['Interwood Corporate Website','WordPress,Custom Theme,Responsive','https://corporate.interwood.pk/','projects/interwood-corporate-live.jpg','Converted approved designs into a responsive WordPress experience with custom theme and plugin work.','Custom theme development.\nResponsive implementation.\nPlugin and content customization.'],
 ['Refuse Fab Product Experience','WordPress,WooCommerce,Frontend','https://refusefab.com/','projects/refuse-fab-products-live.jpg','Customized the WooCommerce product-detail experience around clearer product information and responsive behavior.','Product detail customization.\nResponsive storefront behavior.\nWooCommerce frontend improvements.'],
 ['IPC Center WordPress Platform','WordPress,WooCommerce,Customization','https://ipccenter.net/','projects/ipc-center-live.jpg','Delivered WordPress and WooCommerce customization across content, storefront presentation and responsive behavior.','Content experience customization.\nWooCommerce presentation.\nResponsive quality improvements.'],
]; }
