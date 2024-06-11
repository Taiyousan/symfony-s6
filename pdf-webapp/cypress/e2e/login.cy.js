describe('Formulaire de Connexion', () => {
    it('test 1 - connexion OK', () => {
        cy.visit('localhost:8000/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('cypress@cypress.fr');
        cy.get('#password').type('cypress');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('Bienvenue, Cypress!').should('exist');
    });

    it('test 2 - connexion KO', () => {
        cy.visit('localhost:8000/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('faux@etudiant.univ-reims.fr');
        cy.get('#password').type('faux');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('Invalid credentials').should('exist');
    });
});