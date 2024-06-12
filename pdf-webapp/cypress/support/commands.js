// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
Cypress.Commands.add('login', (email, password) => {
    cy.visit('http://localhost:8000/login'); // Visitez la page de connexion

    cy.get('input[name="_username"]').should('be.visible').type(email); // Attendez que le champ soit visible puis tapez le nom d'utilisateur
    cy.get('input[name="_password"]').should('be.visible').type(password); // Attendez que le champ soit visible puis tapez le mot de passe

    cy.get('form').submit(); // Soumettez le formulaire
});



//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })