<html>
  <head>
    <title>Load Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style>
      * { margin: 0; padding: 0; font-family: 'Roboto', sans-serif; }

      #load {
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
        max-width: 400px;
        max-height: 200px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: box-shadow 0.4s ease-in-out 0s;
      }

      h1 {
        font-size: 1.2rem;
        margin-bottom: 6px;
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
    <section id="load-page">
      <div id="load">
        <div class="modal">
          <h1>Load Questions</h1>
          <input type="text" placeholder="Definition" id="definition"/>
          <input type="text" placeholder="Answer" id="answer"/>
          <button type="button" onclick="loadQuestion()">Load Question</button>
        </div>
      </div>
    </section>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script>
    let def = $("#definition");
    let ans = $("#answer");

    $("#answer").keypress((e) => {
      if (e.which == 13) {
        loadQuestion();
      }
    });

    function loadQuestion() {
      if (def.val() && ans.val()) {
        $.ajax({
          url: "api.php",
          method: "POST",
          data: JSON.stringify({
            "word": ans.val().toLowerCase(),
            "def": def.val()
          }),
          success: () => {
            console.log("sent");
            def.val("");
            ans.val("");
            def.focus();
          },
          error: (err) => {
            console.log(err);
          }
        })
      }
    }
  </script>
</html>
