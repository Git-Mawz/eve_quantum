let app = {

    init: function() {
      const application = new Application();

      /*
      application.loadDependencies({
        baseUrl: new BaseUrl(),
        solarSystemManager: new SolarSystemManager(),
      });
      */
      
      application.run();
    },

    
  };

document.addEventListener('DOMContentLoaded', app.init);