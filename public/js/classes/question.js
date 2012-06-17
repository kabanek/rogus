$.question = {
	initAddForm: function(count_answers) {
		this.count_answers = count_answers;
		
		$('#count_answers-element').append('<a href="#" onclick="return $.question.addOptionForm()" id="add-element">Dodaj kolejną odpowiedź</a>');
	},
	addOptionForm: function() {
		var id = '#correct_answer_' + this.count_answers + '-element';
		console.log($(id));
		$(id).after('<dt id="answer_' + ( this.count_answers + 1 ) + '-label"><label class="optional" for="answer_' + ( this.count_answers + 1 ) + '">Odpowiedź nr ' + ( this.count_answers + 1 ) + '</label></dt><dd id="answer_' + ( this.count_answers + 1 ) + '-element"><input id="answer_' + ( this.count_answers + 1 ) + '" type="text" value="" name="answer_' + ( this.count_answers + 1 ) + '"></dd>'
				+ '<dt id="correct_answer_' + ( this.count_answers + 1 ) + '-label"><label class="optional" for="correct_answer_' + ( this.count_answers + 1 ) + '">Czy odpowiedź nr ' + ( this.count_answers + 1 ) + ' jest prawidłową odpowiedzią?</label></dt>'
				+ '<dd id="correct_answer_' + ( this.count_answers + 1 ) + '-element"><input type="hidden" value="0" name="correct_answer_' + ( this.count_answers + 1 ) + '"><input id="correct_answer_' + ( this.count_answers + 1 ) + '" type="checkbox" value="1" name="correct_answer_' + ( this.count_answers + 1 ) + '"></dd>');
		
		++this.count_answers;
		$('#count_answers').val(this.count_answers);
		return false;
	},
	count_answers: 0
};