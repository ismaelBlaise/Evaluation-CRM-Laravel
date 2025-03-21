SET foreign_key_checks = 0;

DELETE FROM crm2.leads;

DELETE FROM crm2.comments;

DELETE FROM crm2.mails;

DELETE FROM crm2.tasks;

DELETE FROM crm2.projects;

DELETE FROM crm2.absences;

DELETE FROM crm2.contacts;

DELETE FROM crm2.invoice_lines;

DELETE FROM crm2.appointments;

DELETE FROM crm2.payements;

DELETE FROM crm2.invoices;

DELETE FROM crm2.offers;

DELETE FROM crm2.clients;


DELETE FROM crm2.users
WHERE id NOT IN (
    SELECT user_id
    FROM crm2.role_user ru
    JOIN crm2.roles r ON ru.role_id = r.id
    WHERE r.name = 'administrator'
);


DELETE FROM crm2.role_user
WHERE user_id NOT IN (
    SELECT user_id
    FROM crm2.role_user ru
    JOIN crm2.roles r ON ru.role_id = r.id
    WHERE r.name = 'administrator'
);

DELETE FROM crm2.department_user
WHERE user_id IN (
    SELECT user_id
    FROM crm2.role_user ru
    JOIN crm2.roles r ON ru.role_id = r.id
    WHERE r.name = 'administrator'
);


-- DELETE FROM crm2.products;

-- DELETE FROM crm2.subscriptions;

-- DELETE FROM crm2.activities;


SET foreign_key_checks = 0;

