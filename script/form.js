const form = document.querySelector("#form")
var nomeInput = document.querySelector("#nome")
const emailInput = document.querySelector("#email")
const telefoneInput = document.querySelector("#telefone")
const assuntoTextarea = document.querySelector("#assunto")
const mensagemTextarea = document.querySelector("#mensagem")




form.addEventListener("submit",(event) => {

    event.preventDefault();

 //Verifica o Nome//
    if(nomeInput.value === ""){
        alert("Preencha o seu nome.");
        return;   
    }

//Verifica o email//
    if(emailInput.value === "") {
        alert("Preencha o seu email.");
    return;   
    } 

//Verifica Telefone//
    if(!validateTelefone(telefoneInput.value, 11)) {
        alert("O telefone deve conter 11 dígitos.");
    return;
    }

//Verifica o assunto//
    if(assuntoTextarea.value === "") {
    alert("o assunto não pode estar vazio.");
    return;   
} 

//Verifica a mensagem//
    if(mensagemTextarea.value === "") {
    alert("A mensagem não pode estar vazia.");
    return;   
} 


// Todos os Campos//
    form.submit()
      
})






function validateTelefone(Telefone, minDigits){
        if( Telefone.length >= minDigits){
        return true
        }

         return false
}    


function receberForm(form){
    const nomeInput = document.querySelector("#nome").value
    const emailInput = document.querySelector("#email").value
    const telefoneInput = document.querySelector("#telefone").value
    const assuntoTextarea = document.querySelector("#assunto").value
    const mensagemTextarea = document.querySelector("#mensagem").value

    console.log(nomeInput, emailInput, telefoneInput, assuntoTextarea, mensagemTextarea )
}

function excluir() {
    if (confirm("Tem certeza que deseja excluir todos os seus pedidos?")) {
        fetch('delete_items.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                location.reload(); // Recarregar a página para atualizar a lista de pedidos
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    }
}

