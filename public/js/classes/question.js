$.question = {
	initAddForm: function(count_answers) {
		this.count_answers = count_answers;
		
		$('#count_answers-element').append('<a href="#" id="add-element">Dodaj kolejną odpowiedź</a>');
		
		console.log($('#add-element'));
		
		$('#add-element').click(function(){
			$('#correct_answer' + this.count_answers + '-element').after('<dt id="answer_' + ( this.count_answers + 1 ) + '-label"><label class="optional" for="answer_' + ( this.count_answers + 1 ) + '">Odpowiedź nr ' + ( this.count_answers + 1 ) + '</label></dt><dd id="answer_' + ( this.count_answers + 1 ) + '-element"><input id="answer_' + ( this.count_answers + 1 ) + '" type="text" value="" name="answer_' + ( this.count_answers + 1 ) + '"></dd>');
			
			++this.count_answers;
			return false;
		});
		
	},
	count_answers: 0
};