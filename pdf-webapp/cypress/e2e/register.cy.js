describe('Registration Form', () => {
    beforeEach(() => {
        // Remplacez l'URL par celle de votre application
        cy.visit('http://localhost:8000/register');
    });

    it('should successfully register a new user', () => {
        // Remplir le champ Prénom
        cy.get('input[name="registration_form[firstname]"]').type('CypressRegister');

        // Remplir le champ Nom
        cy.get('input[name="registration_form[lastname]"]').type('CypressRegister');

        // Sélectionner un abonnement dans le menu déroulant
        cy.get('select[name="registration_form[subscription]"]').select('1'); // Assurez-vous que l'ID '1' correspond à un abonnement valide

        // Remplir le champ Email
        cy.get('input[name="registration_form[email]"]').type('cypress.register@example.com');

        // Remplir le champ Mot de passe
        cy.get('input[name="registration_form[plainPassword]"]').type('cypress-register-password123456');

        // Soumettre le formulaire
        cy.get('form').submit();

        // Vérifiez si l'inscription a réussi
        // Vous pouvez ajuster cette vérification en fonction du comportement de votre application après l'inscription
        cy.url().should('include', '/'); // Remplacez '/some-success-page' par l'URL attendue après l'inscription réussie
    });

    it('should display validation errors for invalid inputs', () => {
        // Laissez le champ Prénom vide
        cy.get('input[name="registration_form[firstname]"]').type('Fake');

        // Remplir le champ Nom
        cy.get('input[name="registration_form[lastname]"]').type('Doe');

        // Sélectionner un abonnement dans le menu déroulant
        cy.get('select[name="registration_form[subscription]"]').select('1'); // Assurez-vous que l'ID '1' correspond à un abonnement valide

        // Remplir le champ Email avec une adresse invalide
        cy.get('input[name="registration_form[email]"]').type('emailnonvalide');

        // Remplir le champ Mot de passe avec un mot de passe trop court
        cy.get('input[name="registration_form[plainPassword]"]').type('123');

        // Soumettre le formulaire
        cy.get('form').submit();

        // Vérifiez si des erreurs de validation sont affichées
        cy.contains('Votre mot de passe doit contenir au moins 6 caractères').should('be.visible');
        // cy.contains('There is already an account with this email').should('be.visible'); // Ajustez ce texte en fonction du message d'erreur réel
    });
});
