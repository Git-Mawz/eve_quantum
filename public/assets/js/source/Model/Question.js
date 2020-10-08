class Question {

    _data;


    loadData(data) {
        this._data = data;
        return this;
    }

    getQuestionTitle() {
        return this._data.title;
    }

    getQuestionId() {
        return this._data.id;
    }

    // foo() {
    //     /** ici du code */
    //     console.log('called foo');
    //     return this;
    // }

    // bar() {
    //     /** ici du code */
    //     console.log('called bar');
    //     return this;
    // }
}
