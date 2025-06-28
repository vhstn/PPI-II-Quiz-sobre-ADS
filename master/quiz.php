<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Responder Quiz</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #667eea, #764ba2);
      padding: 2rem;
      color: #333;
    }
    .container {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      max-width: 900px;
      margin: auto;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }
    .question {
      margin-bottom: 2rem;
    }
    .question p {
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    .question label {
      display: block;
      margin: 4px 0;
    }
    button {
      background-color: #6699ff;
      color: white;
      padding: 12px;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      display: block;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Quiz ADS</h2>
    <form id="quiz-form">
      <div class="question">
        <p>1. O que significa a sigla HTML?</p>
        <label><input type="radio" name="q1" value="a"> HyperText Markup Language</label>
        <label><input type="radio" name="q1" value="b"> HyperText Machine Language</label>
        <label><input type="radio" name="q1" value="c"> HighText Markup Language</label>
        <label><input type="radio" name="q1" value="d"> HyperTool Markup Language</label>
      </div>

      <div class="question">
        <p>2. Qual linguagem é utilizada para estilizar páginas web?</p>
        <label><input type="radio" name="q2" value="a"> PHP</label>
        <label><input type="radio" name="q2" value="b"> HTML</label>
        <label><input type="radio" name="q2" value="c"> CSS</label>
        <label><input type="radio" name="q2" value="d"> SQL</label>
      </div>

      <div class="question">
        <p>3. Qual comando é usado para imprimir algo no console em JavaScript?</p>
        <label><input type="radio" name="q3" value="a"> print()</label>
        <label><input type="radio" name="q3" value="b"> echo()</label>
        <label><input type="radio" name="q3" value="c"> log.console()</label>
        <label><input type="radio" name="q3" value="d"> console.log()</label>
      </div>

      <div class="question">
        <p>4. Qual dessas linguagens é utilizada no backend?</p>
        <label><input type="radio" name="q4" value="a"> HTML</label>
        <label><input type="radio" name="q4" value="b"> PHP</label>
        <label><input type="radio" name="q4" value="c"> CSS</label>
        <label><input type="radio" name="q4" value="d"> XML</label>
      </div>

      <div class="question">
        <p>5. O que é um banco de dados relacional?</p>
        <label><input type="radio" name="q5" value="a"> Um banco com arquivos de texto</label>
        <label><input type="radio" name="q5" value="b"> Um banco baseado em documentos</label>
        <label><input type="radio" name="q5" value="c"> Um banco com relações entre tabelas</label>
        <label><input type="radio" name="q5" value="d"> Um banco em nuvem</label>
      </div>

      <button type="submit">Finalizar Quiz</button>
    </form>
  </div>
</body>
</html>
