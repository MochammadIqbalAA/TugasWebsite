function calculate() {
    const num1 = parseFloat(document.getElementById('num1').value) || 0;
    const num2 = parseFloat(document.getElementById('num2').value) || 0;
    const sum = num1 + num2;
    document.getElementById('result').innerHTML = `Hasil: ${sum}`;
}

function reset() {
    document.getElementById('num1').value = '';
    document.getElementById('num2').value = '';
    document.getElementById('result').innerHTML = '';
}