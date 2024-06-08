describe('Register form testing', () => {
    it('should successfuly submit the registration form', () => {
        //Accessing the project's register page
        cy.visit('http://localhost:3000/register.php');

        //Fill out the form
        cy.get('input[name="firstName"]').type('TestFirstName1');
        cy.get('input[name="lastName"]').type('TestLastName1');
        cy.get('input[name="password"]').type('Password1');
        cy.get('input[name="confPassword"]').type('Password1');
        cy.get('input[name="emailAddress"]').type('testemail1@gmail.com');

        //Submit button
        cy.get('button[type="submit"]').click();

        //Check for success message
        cy.url().should('include', 'register.php?success=true');
        cy.contains('Your account has been created. You can now login!').should('be.visible');
    });
});