console.log("QuestionManager.js loaded");

class QuestionManager
{
  

  endPoints = {
    getQuestions: '/api/question/browse'
  };

  loadQuestions() {
    return fetch(this.endPoints.getQuestions).then((response) => {
      return response.json();
    }).then((rawData) => {
      console.log(rawData);

      const questions = JSON.parse(rawData.questions);

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
