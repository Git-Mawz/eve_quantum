class Application
{


  run() {
    console.log("Application start");

    // micro router
    if(document.location.toString().match(/question\/list/)) {
      this.actionQuestionAutocompletion();
    }
  }


  // micro controller
  actionQuestionAutocompletion() {
    console.log("%cQuestion autocompletion", 'font-size: 1.1rem;');

    const selector = ".component-question-autocompletion";

    const questionAutocompletion = new QuestionAutocompletion(
      document.querySelector(selector)
    );

    questionAutocompletion.initialize();



  }

}