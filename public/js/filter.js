const response = await fetch('/api/pontos');
const data = await response.json();

console.log(data)