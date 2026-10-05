@extends('layouts.app')

@section('title', 'AI Assistant')

@section('content')

<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="fw-bold mb-4">
                <i class="bi bi-robot"></i>
                MyShop AI Assistant
            </h2>

            <a href="/dashboard" class="btn btn-outline-secondary mb-4">
                <i class="bi bi-arrow-left"></i>
                Back to MyShop
            </a>

            <form id="aiForm">

                @csrf

                <div class="mb-3">
                    <label for="question" class="form-label">
                        Ask something
                    </label>

                    <textarea
                        id="question"
                        name="question"
                        class="form-control"
                        rows="4"
                        placeholder="Ask about products..."
                        required
                    ></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i>
                    Ask AI
                </button>

            </form>

            <div id="loading" class="mt-3" style="display: none;">
                <div class="alert alert-info">
                    AI is thinking...
                </div>
            </div>

            <div id="answerBox" class="mt-4" style="display: none;">

                <h5 class="fw-bold">AI Answer</h5>

                <div id="answer" class="alert alert-success"></div>

            </div>

        </div>
    </div>

</div>

<script>
document.getElementById('aiForm').addEventListener('submit', function(event) {

    event.preventDefault();

    let question = document.getElementById('question').value;
    let loading = document.getElementById('loading');
    let answerBox = document.getElementById('answerBox');
    let answer = document.getElementById('answer');

    loading.style.display = 'block';
    answerBox.style.display = 'none';

    fetch('/ai/ask', {
        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },

        body: JSON.stringify({
            question: question
        })
    })

    .then(response => response.json())

    .then(data => {

        loading.style.display = 'none';
        answerBox.style.display = 'block';

        if (data.answer) {
           answer.innerText = data.answer;
           } 
        else if (data.message) {
           answer.innerText = data.message;
           } 
        else {
           answer.innerText = 'Something went wrong.';
           console.log(data);
           }
    })

    .catch(error => {

        loading.style.display = 'none';
        answerBox.style.display = 'block';

        answer.innerText = 'Unable to connect to AI.';

        console.error(error);
    });

});
</script>

@endsection