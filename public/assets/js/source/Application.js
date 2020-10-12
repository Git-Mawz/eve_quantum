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

    // Search Engine
    console.log("%cQuestion search engine", 'font-size: 1.1rem;');
    const selector = ".component-question-search-engine";
    const questionSearchEngine = new QuestionSearchEngine(
      document.querySelector(selector)
    );
    questionSearchEngine.initialize();
    

    // Question by Category component

    // Initialize baseUrl
    let baseUrl = new BaseUrl();
    const manager = new QuestionManager();


    console.log("%cQuestion by category", 'font-size: 1.1rem;');
    const questionDisplayByCategory = new QuestionDisplayByCategory(baseUrl, manager);
    questionDisplayByCategory.initialize();
  }

}