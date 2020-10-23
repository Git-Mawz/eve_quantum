class QuestionDisplayByCategory
{

  _curentTarget;
  _categoryId;
  _tbodyInitialInnerHTML;

  _baseUrl;
  _questionRepository

  constructor(baseUrl, questionRepository) {
    this._tbodyInitialInnerHTML = document.querySelector('.search-result-tbody').innerHTML;
    this._baseUrl = baseUrl;
    this._questionRepository = questionRepository;
  }


  initialize() {
    console.log('initialize QuestionDisplayByCategory');
    document.addEventListener('click', (event) => {this.handleClickOnCategory(event)})
  }

  handleClickOnCategory(event) {
      // console.log(event.target);
      this._curentTarget = event.target;
      this._categoryId = this._curentTarget.dataset.category;

      // console.log(this._categoryId);
      if (isNaN(this._categoryId)) {
        console.log('Dataset category NaN')
      } else {

        // Initialize baseUrl
        // let baseUrl = new BaseUrl();
        let baseUrl = this._baseUrl.getBaseUrl();
        
        // initialize tbody
        let tbody = document.querySelector('.search-result-tbody');
        
        // const manager = new QuestionManager();
        
        this._questionRepository.loadQuestionByCategory(this._categoryId).then((questionList) => {
          
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

}