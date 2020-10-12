class QuestionDisplayByCategory
{

  _curentTarget;
  _categoryId;
  _tbodyInitialInnerHTML;

  constructor() {
    this._tbodyInitialInnerHTML = document.querySelector('.search-result-tbody').innerHTML;
  }


  initialize() {
    console.log('initialize QuestionDisplayByCategory');

    const manager = new QuestionManager();
    document.addEventListener('click', (event) => {this.handleClickOnCategory(event)})

  }

  handleClickOnCategory(event) {
      console.log(event.target);
      this._curentTarget = event.target;
      this._categoryId = this._curentTarget.className.slice(18,20);

      console.log(this._categoryId);

      // Initialize baseUrl
      let baseUrl = new BaseUrl();
      baseUrl = baseUrl.getBaseUrl();

      // initialize tbody
      let tbody = document.querySelector('.search-result-tbody');

      const manager = new QuestionManager();
      manager.loadQuestionByCategory(this._categoryId).then((questionList) => {
        
        // init of tbody to prepare search results
        tbody.innerHTML = '';
        
        for (let question of questionList) {
          
          let date = new Date(question.getCreatedAt());
          
          tbody.innerHTML += 
          '<td><a href="' + baseUrl + '/read/' + question.getSlug() + '">' + question.getTitle() + '</a></td>' +
          '<td>' + question.getCategory().name + '</td>' +
          '<td scope="row">' + question.getUser().name + '</td>' +
          '<td>' + date.getDate()+ '/' + date.getMonth() + '/' + date.getFullYear() + ' à ' + date.getHours() + ':' + date.getMinutes() + '</td>';
          
        }
        
        
      });
     
  }

}