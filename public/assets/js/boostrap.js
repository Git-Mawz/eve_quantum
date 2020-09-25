let app = {

    init: function() {
      /*
      let question = new Question;
      question.load();
      console.log(question);
      */

      const application = new Application();
      application.run();
    },

    
  };

document.addEventListener('DOMContentLoaded', app.init);