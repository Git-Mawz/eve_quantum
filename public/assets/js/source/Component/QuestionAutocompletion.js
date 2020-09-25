console.log("QuestionAutocompletion.js loaded");

class QuestionAutocompletion
{

  _input;

  constructor(targetElement) {
    this._input = targetElement;
    console.log(this._input);
  }

  initialize() {
    console.log('initialize QuestionAutocompletion');
    console.log(this._input);
    
    this._input.addEventListener('keyup', (event) => {
      this.handleChange(event);
    });
  }

  handleChange(event) {
    //let input = event.currentTarget;
    const search = this._input.value;
    console.log(search);

    const manager = new QuestionManager();
    manager.loadQuestions().then((questionList) => {
      console.log(questionList);
      for (let questionInstance of questionList) {
        console.log(questionInstance.getQuestion());

        questionInstance.foo().bar();

      }
    });

  }



}