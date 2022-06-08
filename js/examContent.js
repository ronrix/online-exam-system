// months
const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

const exams = document.querySelectorAll(".exam");

const modalWrapper = document.querySelector("#modalWrapper");
const modalName = document.querySelector("#modal_name");
const modal_startTime = document.querySelector("#modal_startTime");
const modal_endTime = document.querySelector("#modal_endTime");
const modal_editBtn = document.querySelector("#modal_editBtn");
const serverLink = document.querySelector(".serverLink");
const examID = document.querySelector(".examID");

exams.forEach(el => {
    el.addEventListener("click", e => {
        const key = e.target.id;

        fetch("http://localhost/OnlineExamApp/controller/exam_content.controller.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            body: JSON.stringify({ key: key })
        })
            .then(res => res.json())
            .then(data => {
                // start time - date
                let Sdate = data.startTime.split(" ")[0];
                const Syear = Sdate.split("-")[0];
                const Smonth = Sdate.split("-")[1];
                const Sday = Sdate.split("-")[2];

                // end time
                let Edate = data.endTime.split(" ")[0];
                const Eyear = Edate.split("-")[0];
                const Emonth = Edate.split("-")[1];
                const Eday = Edate.split("-")[2];

                Edate = Edate.replaceAll("-", "/");

                serverLink.id = data.serverLink;
                examID.id = data.examID;

                // check if date was already expired
                if (new Date(Edate).getTime() < new Date().getTime()) {
                    modalName.textContent = data.examName;
                    modalWrapper.id = data.examID;
                    modal_editBtn.style.display = "none";
                    modal_startTime.textContent = `Ended on ${
                        months[Emonth.toString()[0] == "0" ? Emonth.toString()[1] - 1 : months[Emonth - 1]]
                    } ${Eday}th`;
                    modal_endTime.textContent = "";
                    modal_endTime.innerHTML = `<a href="./display/show.view.php?eid=${data.examID}&en=${data.examName}">show result</a>`;
                    document.querySelector("#downloadResult").style.display = "block";
                    return;
                } else {
                    modalName.textContent = data.examName;
                    modalWrapper.id = data.examID;
                    modal_startTime.textContent = `Start Time: ${Syear} ${Smonth} ${Sday}`;
                    modal_endTime.textContent = `End Time: ${Eyear} ${Emonth} ${Eday}`;
                    document.querySelector("#downloadResult").style.display = "none";
                }
            });
    });
});

// delete exam from the db
const delExam = document.querySelector("#deleteExam");

delExam.addEventListener("click", e => {
    fetch("http://localhost/OnlineExamApp/controller/deleteExam.controller.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify({ key: e.target.parentElement.parentElement.parentElement.id })
    })
        .then(data => data.json())
        .then(res => {
            window.location.reload();
        });
});
