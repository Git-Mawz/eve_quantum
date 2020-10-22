class Application
{
  run() {
    console.log("Application start");

    // micro router
    if(document.location.toString().match(/question\/list/)) {
      this.actionQuestionSearchEngine();
    }

    if(document.location.toString().match(/profile/)) {
      this.actionSolarSystemSearchEngine();
      this.actionFavoriteSolarSystemManager();
    }

  }


  // micro controller Questions
  actionQuestionSearchEngine() {
    // Search Engine
    console.log("%cQuestion search engine", 'font-size: 1.1rem;');
    const selector = ".component-question-search-engine";
    const questionSearchEngine = new QuestionSearchEngine(
      document.querySelector(selector)
    );
    questionSearchEngine.initialize();
    
    // Question by Category component
    console.log("%cQuestion by category", 'font-size: 1.1rem;');
    const baseUrl = new BaseUrl();
    const manager = new QuestionManager();
    const questionDisplayByCategory = new QuestionDisplayByCategory(baseUrl, manager);
    questionDisplayByCategory.initialize();
  }

  // micro controller Solar System
  actionSolarSystemSearchEngine() {
    // Search Engine
    console.log("%cSolar System Search engine", 'font-size: 1.1rem;');
    const baseUrl = new BaseUrl();
    const manager = new SolarSystemManager();
    const form = document.querySelector(".solar-system-form");
    const input = document.querySelector(".component-solar-system-search");
    const solarSystemSearchEnigne = new SolarSystemSearchEngine(baseUrl, form, input, manager);
    solarSystemSearchEnigne.initialize();

    // Favorite Solar System management
    // const favoriteSolarSystemManager = new FavoriteSolarSystemManager(manager);
    // favoriteSolarSystemManager.initialize();
  }

  // Favorite Solar System Manager
  actionFavoriteSolarSystemManager() {
    const manager = new SolarSystemManager();
    const favoriteSolarSystemManager = new FavoriteSolarSystemManager(manager);
    favoriteSolarSystemManager.initialize();
  }

}