console.log("QuestionSearchEngine.js loaded");

class QuestionSearchEngine
{

  _input;
  _tbodyInitialValue;

  constructor(targetElement) {
    this._input = targetElement;
    this._tbodyInitialInnerHTML = document.querySelector('.search-result-tbody').innerHTML;
  }

  initialize() {
    console.log('initialize QuestionSearchEngine');
    console.log(this._input);
    
    this._input.addEventListener('keyup', (event) => {
      this.handleChange(event);
    });
    
  }

  handleChange(event) {
    //let input = event.currentTarget;
    const search = this._input.value.toLowerCase();
    console.log(search);

    const manager = new QuestionManager();
    manager.loadQuestions().then((questionList) => {

      // Initialize search result 
      let searchResult = [];

      // Initialize caseUrl
      let baseUrl = new BaseUrl();
      baseUrl = baseUrl.getBaseUrl();
      // console.log(baseUrl);
      
      // Initialize tbody element
      let tbody = document.querySelector('.search-result-tbody');
      
      // console.log(this._tbodyInitialInnerHTML);

      // matching between title and input value
      for (let questionInstance of questionList) {
        if (questionInstance.getTitle().toLowerCase().includes(search) == true) {
          searchResult.push(questionInstance);
        }
      }

      // using original value if nothing in search input
      if (this._input.value.length == 0) {
        tbody.innerHTML = this._tbodyInitialInnerHTML;
        searchResult = [];
      } else {
        tbody.innerHTML = '';
      }

      // display of search result in the table
      for (let questionToDisplay of searchResult) {

        // date format 08/10/2020 à 17:43
        let date = new Date(questionToDisplay.getCreatedAt());

        tbody.innerHTML += 
          '<td><a href="' + baseUrl + '/read/' + questionToDisplay.getSlug() + '">' + questionToDisplay.getTitle() + '</a></td>' +
          '<td>' + questionToDisplay.getCategory().name + '</td>' +
          '<td scope="row">' + questionToDisplay.getUser().name + '</td>' +
          '<td>' + date.getDate()+ '/' + date.getMonth() + '/' + date.getFullYear() + ' à ' + date.getHours() + ':' + date.getMinutes() + '</td>';

      }

    });

  }

}