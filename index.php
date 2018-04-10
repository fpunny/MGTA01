<html>
  <head>
    <title>Quiz Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      * { margin: 0; padding: 0; font-family: 'Roboto', sans-serif; }

      #quiz {
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0,0,0,0.14);
      }

      .modal {
        background-color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 36px 20px;
        width: 100%;
        height: 100%;
        max-width: 600px;
        max-height: 300px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: box-shadow 0.4s ease-in-out 0s;
      }

      h1 {
        font-size: 1.2rem;
        margin-bottom: 6px;
        text-align: center;
      }

      input[type="text"] {
        padding: 14px 16px;
        margin: 4px 6px;
        width: 90%;
        font-size: 0.85rem;
        font-weight: bold;
        border: none;
        background-color: rgba(0,0,0,0.06);
        transition: background-color 0.4s ease-in-out 0s;
      }

      button {
        margin-top: 8px;
        padding: 14px 28px;
        color: white;
        border: none;
        background-color: #0cd05a;
        transition: background-color 0.4s ease-in-out 0s;
      }

      button:hover {
        background-color: #14c259;
      }

      input[type="text"]:hover {
        background-color: rgba(0,0,0,0.09);
      }

      .modal:hover {
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
      }

    </style>
  </head>
  <body>
    <section id="quiz-page">
      <div id="quiz">
        <div class="modal">
          <h1 id="definition"></h1>
          <input type="text" placeholder="Answer" id="answer"/>
          <button type="button" onclick="checkAnswer()">Submit</button>
        </div>
      </div>
    </section>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script>

    let def = $("#definition");
    let ans = $("#answer");
    let index = 0;
    let db = [];

    $.ajax({
      url: "api.php",
      method: "GET",
      success: (data) => {
        db = data.data;
        loadQuestion();
      },
      error: (err) => {
        console.log(err);
      }
    });

    $("#answer").keypress((e) => {
      if (e.which == 13) {
        checkAnswer();
      }
    });

    function checkAnswer() {
      if (ans.val().toLowerCase() == db[index].word) {
        console.log("Correct!");
      } else {
        alert("Wrong. Answer is : " + db[index].word);
      }
      loadQuestion();
    }

    function loadQuestion() {
      index = Math.floor(Math.random()*db.length);
      def.text(db[index].def);
      ans.val("");
    }
  </script>
</html>
