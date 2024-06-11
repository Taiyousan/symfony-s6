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

        // Vérifie si le PDF est généré en vérifiant le type de contenu de la réponse
        cy.request('POST', 'http://localhost:8000/generate-pdf', {
            url: 'https://google.com'
        }).then((response) => {
            expect(response.headers['Content-Type']).to.eq('application/pdf');
        });
    });

    it('should not display the form if the user has reached the daily limit', () => {
        // Simulez le cas où l'utilisateur a atteint sa limite quotidienne
        // Vous pouvez modifier la configuration de votre base de données pour simuler cela, ou moquer la réponse API

        // Rechargez la page après avoir modifié la configuration
        cy.visit('http://localhost:8000/generate-pdf');

        // Vérifie si le formulaire n'est pas visible
        cy.get('form[name="generate_pdf"]').should('not.exist');

        // Vérifie le message indiquant que la limite est atteinte
        cy.contains('Vous avez atteint votre limite quotidienne de génération de PDF').should('be.visible');
    });
});
