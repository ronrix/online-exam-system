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

    // order the questions and its options
    quest.forEach((el, id) => {
        // question order
        if (parseInt(el.parentElement.dataset.q) === id + 1) {
            // get options
            const options = [];
            option.forEach((el) => {
                if (parseInt(el.parentElement.parentElement.dataset.q) === 1) {
                    options.push(el.value);
                }
            });
            // get selection value
            let selected = "";
            select.forEach((el) => {
                if (parseInt(el.parentElement.dataset.q) === 1) {
                    selected = el.value;
                }
            });
            data.push({
                q: el.value,
                options: options,
                select: selected,
            });
        }
    });

    console.log(JSON.stringify([...data]));
    // submit to the server
    fetch("../../controller/create_exam.controller.php", {
        method: "POST",
        data: data,
    })
        .then((data) => data.json())
        .then((res) => console.log(res))
        .catch((err) => console.error(err));

    // redirect to the server
    // window.location.href = "../../controller/create_exam.controller.php";
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
    removeIcon.classList = "bi bi-dash-lg";

    removeWrapper.appendChild(removeIcon);
    addWrapper.appendChild(addIcon);

    // event for add and remove option
    addWrapper.addEventListener("click", (e) => {
        addOptionElements(e.target.parentElement);
    });

    removeWrapper.addEventListener("click", (e) => {
        e.target.parentNode.parentNode.removeChild(e.target.parentNode);
    });

    // append

    optionWrapper.appendChild(firstOption);
    optionWrapper.appendChild(removeWrapper);
    optionWrapper.appendChild(addWrapper);

    theParent.appendChild(questionInput);
    theParent.appendChild(selectOptions);
    theParent.appendChild(optionWrapper);

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
    el.parentElement.parentElement.appendChild(optionWrapper);
}
// end option function
