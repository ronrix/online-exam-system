// prevent the page from leaving while the exam was not submitted yert
window.onbeforeunload = function () {
    return "Are you sure you want to navigate away?";
};

// set question count for the local storage
localStorage.setItem("questionCount", "1");

// data array
const data = [];

// submitting
const submitBtn = document.querySelector("#submit");
submitBtn.addEventListener("click", () => {
    const quest = document.querySelectorAll("#question");
    const select = document.querySelectorAll("#selectOption");
    const option = document.querySelectorAll("#option");
    const answer = document.querySelectorAll("#answer");

    if (quest[0].value == "") {
        alert("Please input question and options before submitting");
        return;
    }
    // order the questions and its options
    quest.forEach((el, id) => {
        // question order
        if (parseInt(el.parentElement.dataset.q) === id + 1) {
            // get options
            const options = [];
            option.forEach((el) => {
                if (
                    parseInt(el.parentElement.parentElement.dataset.q) ===
                    id + 1
                ) {
                    options.push(el.value);
                }
            });
            // get selection value
            let selected = "";
            select.forEach((el) => {
                if (parseInt(el.parentElement.dataset.q) === id + 1) {
                    selected = el.value;
                }
            });
            // get the answer for this question
            let newAnswer = "";
            answer.forEach((el) => {
                if (
                    parseInt(el.parentElement.parentElement.dataset.q) ===
                    id + 1
                ) {
                    newAnswer = el.value;
                }
            });

            data.push({
                q: el.value,
                options: options,
                select: selected,
                answer: newAnswer,
            });
        }
    });

    // exam details
    const examName = document.querySelector("#exam_name").value;
    const examTime = document.querySelector("#exam_time").value;

    // submit to the server
    const form = document.createElement("form");
    const input = document.createElement("input");
    const examDetailsInput = document.createElement("input");
    const btnSubmit = document.createElement("input");

    form.action = "../../controller/create_exam.controller.php";
    form.method = "POST";

    input.type = "hidden";
    input.name = "data";
    examDetailsInput.type = "hidden";
    examDetailsInput.name = "exam_details";
    input.value = JSON.stringify(data);
    const examData = [{ exam_name: examName, exam_time: examTime }];
    examDetailsInput.value = JSON.stringify(examData);

    btnSubmit.type = "submit";
    btnSubmit.style.opacity = "0";

    form.appendChild(input);
    form.appendChild(examDetailsInput);
    form.appendChild(btnSubmit);

    document.body.appendChild(form);
    //submit
    btnSubmit.click();

    window.onbeforeunload = (e) => {
        return null;
    };
});

// add question
const addQuestionBtn = document.querySelector("#addQuestionBtn");
const questionContainer = document.querySelector("#question_container");

addQuestionBtn.addEventListener("click", (e) => {
    const theParent = document.createElement("div");
    theParent.classList =
        "each_question_wrapper border shadow-sm rounded p-2 mt-2";
    theParent.id = "inside_question_wrapper";

    // update question count
    let count = 0;
    count = theParent.dataset.q =
        parseInt(localStorage.getItem("questionCount")) + 1;
    localStorage.setItem("questionCount", String(count));

    const questionLabel = document.createElement("label");
    questionLabel.for = "question";
    questionLabel.classList = "fw-bold";
    questionLabel.innerHTML = "question";

    const questionInput = document.createElement("input");
    questionInput.classList = "form-control";
    questionInput.placeholder = "write a question";
    questionInput.type = "text";
    questionInput.name = "question";
    questionInput.id = "question";

    const selectOptions = document.createElement("select");
    const checkbox = document.createElement("option");
    const radiobtn = document.createElement("option");
    const definition = document.createElement("option");
    const essay = document.createElement("option");

    selectOptions.classList = "form-select my-2 w-auto";
    selectOptions.name = "selectOption";
    selectOptions.id = "selectOption";
    checkbox.value = "checkbox";
    checkbox.innerHTML = "checkbox";
    radiobtn.value = "radiobutton";
    radiobtn.innerHTML = "radiobutton";
    definition.value = "definition";
    definition.innerHTML = "definition";
    essay.value = "essay";
    essay.innerHTML = "essay";

    selectOptions.appendChild(checkbox);
    selectOptions.appendChild(radiobtn);
    selectOptions.appendChild(definition);
    selectOptions.appendChild(essay);

    // first option
    const optionWrapper = document.createElement("div");
    optionWrapper.classList = "d-flex";
    optionWrapper.id = "options";

    const firstOption = document.createElement("input");
    firstOption.type = "text";
    firstOption.placeholder = "option";
    firstOption.classList = "form-control";
    firstOption.name = "option";
    firstOption.id = "option";

    const removeWrapper = document.createElement("div");
    const addWrapper = document.createElement("div");
    removeWrapper.classList = "p-2";
    removeWrapper.id = "removeOption";
    addWrapper.classList = "p-2";
    addWrapper.id = "addOption";

    const addIcon = document.createElement("i");
    const removeIcon = document.createElement("i");

    addIcon.classList = "bi bi-plus-lg";
    addIcon.style.pointerEvents = "none";
    removeIcon.classList = "bi bi-dash-lg";
    removeIcon.style.pointerEvents = "none";

    removeWrapper.appendChild(removeIcon);
    addWrapper.appendChild(addIcon);

    // event for add and remove option
    addWrapper.addEventListener("click", (e) => {
        console.log(e.target);
        addOptionElements(e.target);
    });

    removeWrapper.addEventListener("click", (e) => {
        e.target.parentNode.parentNode.removeChild(e.target.parentNode);
    });

    // answer element
    const answerDiv = document.createElement("div");
    const answerLabel = document.createElement("h6");
    const answerInput = document.createElement("input");

    answerDiv.classList = "my-2";
    answerLabel.classList = "fw-bold";
    answerLabel.innerHTML = "Answer";
    answerInput.classList = "form-control";
    answerInput.type = "text";
    answerInput.id = "answer";
    answerInput.name = "answer";
    answerInput.placeholder = "set the answer";

    answerDiv.appendChild(answerLabel);
    answerDiv.appendChild(answerInput);
    // append

    optionWrapper.appendChild(firstOption);
    optionWrapper.appendChild(removeWrapper);
    optionWrapper.appendChild(addWrapper);

    theParent.appendChild(questionLabel);
    theParent.appendChild(questionInput);
    theParent.appendChild(selectOptions);
    theParent.appendChild(optionWrapper);
    theParent.appendChild(answerDiv);

    questionContainer.appendChild(theParent);
});

// add option
const insideQuestionWrapper = document.querySelector(
    "#inside_question_wrapper"
);
const addOption = document.querySelector("#addOption");
const removeOption = document.querySelector("#removeOption");

addOption.addEventListener("click", (e) => {
    addOptionElements(e.target);
});

removeOption.addEventListener("click", (e) => {
    // check if there's only one option, if there is don't remove it
    if (e.target.parentElement.parentElement.children.length <= 3) {
        console.log("don't remove this first option");
        return;
    }

    e.target.parentNode.parentNode.removeChild(e.target.parentNode);
});

// options function creation
function addOptionElements(el) {
    const optionWrapper = document.createElement("div");
    const optionInput = document.createElement("input");
    const removeWrapper = document.createElement("div");
    const addWrapper = document.createElement("div");

    optionWrapper.id = "options";
    optionWrapper.classList = "d-flex mt-2";

    optionInput.classList = "form-control";
    optionInput.type = "text";
    optionInput.placeholder = "option";
    optionInput.name = "option";
    optionInput.id = "option";

    removeWrapper.classList = "p-2";
    addWrapper.classList = "p-2";

    addWrapper.id = "addOption";
    removeWrapper.id = "removeOption";

    // icons
    const removeIcon = document.createElement("i");
    const addIcon = document.createElement("i");
    addIcon.classList = "bi bi-plus-lg";
    addIcon.style.pointerEvents = "none";
    removeIcon.classList = "bi bi-dash-lg";
    removeIcon.style.pointerEvents = "none";

    // appending childer
    removeWrapper.appendChild(removeIcon);
    addWrapper.appendChild(addIcon);
    optionWrapper.appendChild(optionInput);
    optionWrapper.appendChild(removeWrapper);
    optionWrapper.appendChild(addWrapper);

    // add event listener for add and remove option
    addWrapper.addEventListener("click", (e) => {
        addOptionElements(e.target);
    });

    removeWrapper.addEventListener("click", (e) => {
        e.target.parentNode.parentNode.removeChild(e.target.parentNode);
    });

    // add to the parent question
    el.parentElement.parentNode.insertBefore(
        optionWrapper,
        el.parentElement.parentElement.lastElementChild
    );
}
// end option function
