describe('Error message test', () => {
   
    it('Invalid user', () =>{
    	cy.visit('/login')
        cy.get('input[name=email]').type('example@example.com')
        cy.get('input[name=password]').type('password')
        cy.get('.btn-block').click()
		cy.contains('Usuário ou senha incorretas.')
    })
});