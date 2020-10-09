class Question {

    _data;


    loadData(data) {
        this._data = data;
        return this;
    }
    
    getId() {
        return this._data.id;
    }

    getTitle() {
        return this._data.title;
    }

    getContent() {
        return this._data.content;
    }

    getSlug() {
        return this._data.slug;
    }

    getCategory() {
        return this._data.category;
    }

    getUser() {
        return this._data.user;
    }

    getCreatedAt() {
        return this._data.createdAt;
    }

    getUpdatedAt() {
        return this._data.updatedAt;
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
