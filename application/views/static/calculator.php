<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Calculator</title>
<link rel="canonical" href="http://localhost:8080/paperari/page/static/calculator">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="calculator.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<style>		
html {
  font-size: 62.5%;
  box-sizing: border-box;
}

*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: inherit;
}

body {
  font-family: 'Roboto', sans-serif;
  background-color: #eaeaea;
}

.calculator {
  border: none;
  border-radius: 10px;
  width: 600px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
  background-color: #f9f9f9;
}

.calculator {
  width: 100%;
  max-width: 600px;
}

.calculator-screen {
  width: 100%;
  height: 80px;
  border: none;
  background-color: #252525;
  color: #fff;
  text-align: right;
  padding-right: 20px;
  padding-left: 10px;
  font-size: 4rem;
  font-weight: 500;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.calculator-screen {
  overflow-x: auto;
  white-space: nowrap;
}

button {
  height: 60px;
  font-size: 2.4rem !important;
  font-weight: 400;
  border-radius: 6px;
  transition: all 0.2s ease-in-out;
}

button:active {
  transform: scale(0.97);
}

.operator,
.equal-sign {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
  font-weight: 500;
  border: none;
  background-color: #17a2b8;
  color: white;
}

.operator:hover,
.equal-sign:hover {
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.35);
  transform: translateY(-2px);
}

.equal-sign {
  height: 98%;
  grid-area: 2 / 4 / 6 / 5;
  background-color: #28a745;
}

.calculator-keys {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-gap: 20px;
  padding: 20px;
}

button.btn-light {
  font-size: 3.2rem !important;        /* bigger */
  font-weight: 700 !important;         /* thicker */
  color: #6c757d !important;           /* Bootstrap's muted text color (dark gray) */
  border-radius: 6px;
  transition: background-color 0.2s ease, color 0.2s ease;
}

button.btn-light:hover {
  background-color: #e2e6ea !important;  /* subtle hover bg */
  color: #495057 !important;              /* slightly darker on hover */
}

/* Bigger & muted for operator buttons and equal sign */
button.operator,
button.equal-sign {
  font-size: 3.2rem !important;
  font-weight: 700 !important;
  color: #6c757d !important; /* muted gray */
}

/* Keep font size only for decimal and AC (no color override) */
button.decimal,
button.all-clear {
  font-size: 3.2rem !important;
  font-weight: 700 !important;
  /* No color override */
}

.calculator-screen {
  font-size: 5.6rem;  /* increased from 4rem or 5rem */
}
</style>

  </head>
  <body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh; transform: translateY(-10%);">
      <div class="calculator card">
        <input type="text" class="calculator-screen z-depth-1" value="" disabled />
        <div class="calculator-keys">
          <button type="button" data-mdb-button-init class="operator btn btn-info" value="+">+</button>
          <button type="button" data-mdb-button-init class="operator btn btn-info" value="-">-</button>
          <button type="button" data-mdb-button-init class="operator btn btn-info" value="*">&times;</button>
					<button type="button" data-mdb-button-init class="operator btn btn-info" value="/">&divide;</button>

          <button type="button" data-mdb-button-init value="7" data-mdb-ripple-init class="btn btn-light waves-effect">7</button>
          <button type="button" data-mdb-button-init value="8" data-mdb-ripple-init class="btn btn-light waves-effect">8</button>
          <button type="button" data-mdb-button-init value="9" data-mdb-ripple-init class="btn btn-light waves-effect">9</button>

          <button type="button" data-mdb-button-init value="4" data-mdb-ripple-init class="btn btn-light waves-effect">4</button>
          <button type="button" data-mdb-button-init value="5" data-mdb-ripple-init class="btn btn-light waves-effect">5</button>
          <button type="button" data-mdb-button-init value="6" data-mdb-ripple-init class="btn btn-light waves-effect">6</button>

          <button type="button" data-mdb-button-init value="1" data-mdb-ripple-init class="btn btn-light waves-effect">1</button>
          <button type="button" data-mdb-button-init value="2" data-mdb-ripple-init class="btn btn-light waves-effect">2</button>
          <button type="button" data-mdb-button-init value="3" data-mdb-ripple-init class="btn btn-light waves-effect">3</button>

          <button type="button" data-mdb-button-init value="0" data-mdb-ripple-init class="btn btn-light waves-effect">0</button>
          <button type="button" data-mdb-button-init class="decimal function btn btn-secondary" value=".">.</button>
          <button type="button" data-mdb-button-init class="all-clear function btn btn-danger btn-sm" value="all-clear">AC</button>
          <button type="button" data-mdb-button-init class="equal-sign operator btn btn-default" value="=">=</button>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
const calculator = {
  input: '', // Store expression as string
};

// Update display
function updateDisplay() {
  const display = document.querySelector('.calculator-screen');
  display.value = calculator.input;
}

// Handle digit input
function inputDigit(digit) {
  calculator.input += digit;
  updateDisplay();
}

// Handle decimal point
function inputDecimal(dot) {
  const lastNumber = calculator.input.split(/[\+\-\*\/]/).pop();
  if (!lastNumber.includes(dot)) {
    calculator.input += dot;
    updateDisplay();
  }
}

// Handle operators
function inputOperator(operator) {
  const lastChar = calculator.input.slice(-1);
  if ('+-*/'.includes(lastChar)) {
    // Replace the last operator if two in a row
    calculator.input = calculator.input.slice(0, -1) + operator;
  } else if (calculator.input !== '') {
    calculator.input += operator;
  }
  updateDisplay();
}

function calculateResult() {
  try {
    // Replace any รท with / to make eval safe
    const sanitizedInput = calculator.input.replace(/รท/g, '/');
    const result = eval(sanitizedInput);
    // Always show 3 decimal places
    calculator.input = result.toFixed(3); 
    updateDisplay();
  } catch (error) {
    calculator.input = 'Error';
    updateDisplay();
    setTimeout(() => {
      calculator.input = '';
      updateDisplay();
    }, 1500);
  }
}


// Reset calculator
function resetCalculator() {
  calculator.input = '';
  updateDisplay();
}

// Handle mouse clicks
const keys = document.querySelector('.calculator-keys');
keys.addEventListener('click', (event) => {
  const { target } = event;
  if (!target.matches('button')) return;

  const value = target.value;

  if (target.classList.contains('operator')) {
    inputOperator(value);
    return;
  }

  if (target.classList.contains('decimal')) {
    inputDecimal(value);
    return;
  }

  if (target.classList.contains('equal-sign')) {
    calculateResult();
    return;
  }

  if (target.classList.contains('all-clear')) {
    resetCalculator();
    return;
  }

  inputDigit(value);
});

// Handle keyboard input
document.addEventListener('keydown', (event) => {
  const key = event.key;

  // Prevent browser search when pressing /
  if (key === '/') event.preventDefault();

  if (!isNaN(key)) {
    inputDigit(key);
    return;
  }

  if (['+', '-', '*', '/'].includes(key)) {
    event.preventDefault(); // stop browser default
    inputOperator(key);
    return;
  }

  if (key === '.') {
    inputDecimal(key);
    return;
  }

  if (key === '=' || key === 'Enter') {
    event.preventDefault();
    calculateResult();
    return;
  }

  if (key === 'Escape' || key.toLowerCase() === 'c' || key === 'Delete') {
    resetCalculator();
    return;
  }

  if (key === 'Backspace') {
    calculator.input = calculator.input.slice(0, -1);
    updateDisplay();
  }
});

// Initial display
updateDisplay();
</script>		
  </body>
</html>
