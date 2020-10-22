class Application
{

  _services = {};

  constructor() {
    console.log('instanciation');
  }


  //==================================================================================
  // Manager getters
  //==================================================================================

  getSolarSystemManager() {
    if(typeof(this._services['solarSystemManager']) == 'undefined') {
      this._services['solarSystemManager'] = new SolarSystemManager();
    }
    return this._services['solarSystemManager'];
  }

  getBaseURL() {
    if(typeof(this._services['baseUrl']) == 'undefined') {
      if(document.location.toString().match(/localhost/)) {
        console.log('Loading baseUrl manager');
      }
      this._services['baseUrl'] = new BaseUrl();
    }
    return this._services['baseUrl'];
  }

  getQuestionManager() {
    if(typeof(this._services['questionManager']) == 'undefined') {
      this._services['questionManager'] = new QuestionManager();
    }
    return this._services['questionManager'];
  }

  //==================================================================================

  loadDependencies(dependencies = null) {

    if(dependencies) {
      for(let serviceName in dependencies) {
        this._services[serviceName] = dependencies[serviceName];
      }
    }
  }


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
    const questionDisplayByCategory = new QuestionDisplayByCategory(this.getBaseURL(), this.getQuestionManager());
    questionDisplayByCategory.initialize();
  }

  // micro controller Solar System
  actionSolarSystemSearchEngine() {
    // Search Engine
    console.log("%cSolar System Search engine", 'font-size: 1.1rem;');

    const form = document.querySelector(".solar-system-form");
    const input = document.querySelector(".component-solar-system-search");
    const solarSystemSearchEnigne = new SolarSystemSearchEngine(this.getBaseURL(), form, input, this.getSolarSystemManager());
    solarSystemSearchEnigne.initialize();
  }

  // Favorite Solar System Manager
  actionFavoriteSolarSystemManager() {
    const favoriteSolarSystemManager = new FavoriteSolarSystemManager(this.getSolarSystemManager());
    favoriteSolarSystemManager.initialize();
  }


}