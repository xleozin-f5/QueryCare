$(document).ready(function() {
    $('#contactForm').submit(function(e) {
        e.preventDefault();

        var formData = {
            'name': $('#name').val(),
            'email': $('#email').val(),
            'message': $('#message').val()
        };

        $.ajax({
            type: 'POST',
            url: 'process.php', // Substitua 'process.php' pelo URL do seu script de processamento
            data: formData,
            dataType: 'json',
            encode: true
        })
        .done(function(data) {
            console.log(data);
            alert('Mensagem enviada com sucesso!');
        })
        .fail(function(data) {
            console.log(data);
            alert('Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente mais tarde.');
        });
    });
});
