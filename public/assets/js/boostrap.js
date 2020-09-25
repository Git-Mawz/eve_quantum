let app = {

    init: function() {
      let question = new Question;
      question.load();
      console.log(question);
    },

    
  };

document.addEventListener('DOMContentLoaded', app.init);