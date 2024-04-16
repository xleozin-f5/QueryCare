document.addEventListener('DOMContentLoaded', function() {
    const acceptButtons = document.querySelectorAll('.accept-btn');
    
    acceptButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const postIt = button.closest('.post-it');
            const cancelButton = postIt.querySelector('.cancel-btn');
            cancelButton.style.display = 'none'; // Oculta o botão "Cancelar"
            button.textContent = 'Consulta Aceita'; // Altera o texto do botão "Aceitar"
            button.disabled = true; // Desabilita o botão "Aceitar"
            
            // Remove o botão "Editar"
            const editButton = postIt.querySelector('.edit-btn');
            editButton.style.display = 'none';
            
            // Selecione os dados relevantes da consulta
            const postData = {
                title: postIt.querySelector('.post-it-header h3').textContent.trim(),
                dateParagraph: postIt.querySelector('.post-it-body p:nth-child(1)'),
                timeParagraph: postIt.querySelector('.post-it-body p:nth-child(2)'),
                patient: postIt.querySelector('.post-it-body p:nth-child(3)').textContent.trim(),
                reason: postIt.querySelector('.post-it-body p:nth-child(4)').textContent.trim()
            };
            
            // Atualiza o conteúdo dos parágrafos
            const currentDate = new Date().toLocaleDateString('pt-BR');
            const currentTime = new Date().toLocaleTimeString('pt-BR');
            postData.dateParagraph.textContent = `Data: ${currentDate}`;
            postData.timeParagraph.textContent = `Hora: ${currentTime}`;

            // Armazene os dados da consulta aceita no localStorage
            localStorage.setItem('consultaAceita', JSON.stringify(postData));
            
            // Move a consulta para a página de histórico de consultas
            const historicalPostItContainer = document.querySelector('.historical-post-it-container');
            historicalPostItContainer.appendChild(postIt);
        });
    });
    
    const cancelButtons = document.querySelectorAll('.cancel-btn');
    
    cancelButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const patientName = this.closest('.post-it').querySelector('p:nth-child(3)').textContent.split(':')[1].trim();
            alert(`O paciente ${patientName} será notificado.`);
        });
    });
    
    const editButtons = document.querySelectorAll('.edit-btn');
    
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const postIt = this.closest('.post-it');
            const dateParagraph = postIt.querySelector('p:nth-child(2)');
            const timeParagraph = postIt.querySelector('p:nth-child(3)');
            
            const currentDate = dateParagraph.textContent.split(': ')[1].trim();
            const currentTime = timeParagraph.textContent.split(': ')[1].trim();
            
            const dateInput = document.createElement('input');
            dateInput.type = 'date';
            dateInput.value = currentDate;
            const timeInput = document.createElement('input');
            timeInput.type = 'time';
            timeInput.value = currentTime;
            
            dateParagraph.innerHTML = '';
            dateParagraph.appendChild(dateInput);
            timeParagraph.innerHTML = '';
            timeParagraph.appendChild(timeInput);
            
            button.textContent = 'Salvar';
            
            button.addEventListener('click', function() {
                const newDate = dateInput.value;
                const newTime = timeInput.value;
                
                // Atualiza diretamente o conteúdo da caixa de texto da data e hora
                dateParagraph.textContent = `Data: ${newDate}`;
                timeParagraph.textContent = `Hora: ${newTime}`;
                
                button.textContent = 'Editar';
            });
        });
    });

    // Adiciona um listener de evento para o botão de histórico
    const historicoBtn = document.getElementById('historico-btn');
    historicoBtn.addEventListener('click', function() {
        // Move a consulta para a página de histórico de consultas
        const historicalPostItContainer = document.querySelector('.historical-post-it-container');
        const consultaAceita = JSON.parse(localStorage.getItem('consultaAceita'));
        const postIt = document.createElement('div');
        postIt.classList.add('post-it');
        postIt.innerHTML = `
            <div class="post-it-header">
                <h3>${consultaAceita.title}</h3>
            </div>
            <div class="post-it-body">
                <p>${consultaAceita.dateParagraph.textContent}</p>
                <p>${consultaAceita.timeParagraph.textContent}</p>
                <p><strong>Paciente:</strong> ${consultaAceita.patient}</p>
                <p><strong>Motivo:</strong> ${consultaAceita.reason}</p>
            </div>
        `;
        historicalPostItContainer.appendChild(postIt);
    });
});
