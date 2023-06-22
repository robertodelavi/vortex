function formatCurrency(input) {
    // Remove todos os caracteres que não são dígitos
    var value = input.value.replace(/[^\d]/g, '');

    // Verifica se o campo está vazio
    if (value === '') {
        input.value = '';
        return;
    }

    // Formata o valor em moeda
    var formattedValue = (parseFloat(value) / 100).toFixed(2);

    // Substitui a vírgula por ponto
    formattedValue = formattedValue.replace('.', ',');

    // Adiciona separadores de milhares
    formattedValue = formattedValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Adiciona o símbolo de moeda "$"
    formattedValue = 'R$ ' + formattedValue;

    // Atualiza o valor no campo de entrada
    input.value = formattedValue;
}