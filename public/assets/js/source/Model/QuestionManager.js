console.log("QuestionManager.js loaded");

class QuestionManager
{
  
  endPoints = {
    getQuestions: '/api/question/browse',
    getQuestionsByCategory : '/api/question/category/'
  };

  loadQuestions() {
    return fetch(this.endPoints.getQuestions).then((response) => {
      return response.json();
    }).then((rawData) => {
      // console.log(rawData);

      const questions = rawData.questions;

      let questionList = [];

      for (let data of questions) {
        const question = new Question();
        question.loadData(data);

        // questionList[] = question;
        questionList.push(question);
      }
      return questionList;
    });
  }

  loadQuestionByCategory(categoryId){
    return fetch(this.endPoints.getQuestionsByCategory+categoryId).then((response) => {
      return response.json();
    }).then((rawData) => {
      // console.log(rawData);

      const questions = rawData.questions;

      let questionList = [];

      for (let data of questions) {
        const question = new Question();
        question.loadData(data);

        // questionList[] = question;
        questionList.push(question);
      }
      return questionList;
    });
  }

}
