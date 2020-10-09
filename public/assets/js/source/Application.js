class Application
{


  run() {
    console.log("Application start");

    // micro router
    if(document.location.toString().match(/question\/list/)) {
      this.actionQuestionSearchEngine();
    }
  }


  // micro controller
  actionQuestionSearchEngine() {
    console.log("%cQuestion search engine", 'font-size: 1.1rem;');

    const selector = ".component-question-search-engine";

    const questionSearchEngine = new QuestionSearchEngine(
      document.querySelector(selector)
    );

    questionSearchEngine.initialize();



  }

}