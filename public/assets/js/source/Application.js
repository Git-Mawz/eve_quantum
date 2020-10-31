class Application
{

  _services = {};

  constructor() {
    console.log('instanciation');
  }


  //==================================================================================
  // Repository getters
  //==================================================================================

  getSolarSystemRepository() {
    if(typeof(this._services['solarSystemRepository']) == 'undefined') {
      this._services['solarSystemRepository'] = new SolarSystemRepository();
    }
    return this._services['solarSystemRepository'];
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

  getQuestionRepository() {
    if(typeof(this._services['questionRepository']) == 'undefined') {
      this._services['questionRepository'] = new QuestionRepository();
    }
    return this._services['questionRepository'];
  }

  getLikeRepository() {
    if(typeof(this._services['likeRepository']) == 'undefined') {
      this._services['likeRepository'] = new LikeRepository();
    }
    return this._services['likeRepository'];
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
      this.actionSetDestination();
    }

    if(document.location.toString().match(/question\/read/)) {
      this.actionToggleLike();
    }

  }


  // micro controller Questions
  actionQuestionSearchEngine() {
    // Search Engine
    // console.log("%cQuestion search engine", 'font-size: 1.1rem;');
    const selector = ".component-question-search-engine";
    const questionSearchEngine = new QuestionSearchEngine(document.querySelector(selector), this.getQuestionRepository() );
    questionSearchEngine.initialize();
    
    // Question by Category component
    // console.log("%cQuestion by category", 'font-size: 1.1rem;');
    const questionDisplayByCategory = new QuestionDisplayByCategory(this.getBaseURL(), this.getQuestionRepository());
    questionDisplayByCategory.initialize();
  }

  // micro controller Solar System
  actionSolarSystemSearchEngine() {
    // Search Engine
    // console.log("%cSolar System Search engine", 'font-size: 1.1rem;');

    const form = document.querySelector(".solar-system-form");
    const input = document.querySelector(".component-solar-system-search");
    const solarSystemSearchEnigne = new SolarSystemSearchEngine(this.getBaseURL(), form, input, this.getSolarSystemRepository());
    solarSystemSearchEnigne.initialize();
  }

  // Favorite Solar System Manager
  actionFavoriteSolarSystemManager() {
    const favoriteSolarSystemManager = new FavoriteSolarSystemManager(this.getSolarSystemRepository());
    favoriteSolarSystemManager.initialize();
  }

  // Set in game destination
  actionSetDestination() {
    const inGameSetDestination = new InGameSetDestination();
    inGameSetDestination.initialize();
  }

  // add and remove likes on answer
  actionToggleLike() {
    const toggleLike = new ToggleLike(this.getLikeRepository());
    toggleLike.initialize();
  }


}