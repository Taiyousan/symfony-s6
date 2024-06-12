describe('Generate PDF Page', () => {
    beforeEach(() => {
        // Remplacez par les informations de connexion de votre utilisateur de test
        const email = 'test@test.com';
        const password = '123456';

        // Utiliser la commande de connexion personnalisée
        cy.login(email, password);

        // Attendre que la connexion soit effectuée
        cy.wait(1000); // Ajustez le délai si nécessaire

        // Visiter la page de génération de PDF après la connexion
        cy.visit('http://localhost:8000/generate-pdf');
    });

    it('should display the form if the user has conversions left', () => {
        // Vérifie si le formulaire est visible
        cy.get('form[name="generate_pdf"]').should('be.visible');

        // Vérifie si les éléments du formulaire sont présents
        cy.get('input[name="generate_pdf[url]"]').should('exist');
        cy.get('button[type="submit"]').should('exist');
    });

    it('should generate a PDF when the form is submitted', () => {
        // Remplir le champ URL avec une URL valide
        cy.get('input[name="generate_pdf[url]"]').type('https://google.com');

        // Soumettre le formulaire
        cy.get('form[name="generate_pdf"]').submit();

        cy.contains('Votre PDF a été généré et enregistré avec succès.').should('be.visible');
    });
});
