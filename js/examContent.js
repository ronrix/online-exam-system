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

const modalFooter = document.querySelector(".modal-footer");

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
                let Sdate = data.startTime ?? data?.startTime?.split(" ")[0];
                const Syear = Sdate?.split("-")[0];
                const Smonth = Sdate?.split("-")[1];
                const Sday = Sdate?.split("-")[2];

                // end time
                let Edate = data?.endTime.split(" ")[0];
                const Eyear = Edate.split("-")[0];
                const Emonth = Edate.split("-")[1];
                const Eday = Edate.split("-")[2];

                Edate = Edate.replaceAll("-", "/");

                serverLink.id = data.serverLink;
                examID.id = data.examID;

                // render contents about the exam
                modalName.textContent = data.examName;
                modalWrapper.id = data.examID;
                modal_editBtn.style.display = "none";
                modal_endTime.textContent = "";
                modal_endTime.innerHTML = `<a target="_blank" href="./display/show.view.php?eid=${data.examID}&en=${data.examName}">show result</a>`;

                // check if date was already expired
                if (new Date(Edate).getTime() < new Date().getTime()) {
                    modal_startTime.textContent = `Ended on ${
                        months[Emonth.toString()[0] == "0" ? Emonth.toString()[1] - 1 : months[Emonth - 1]]
                    } ${Eday}th`;
                    if (document.querySelector("#downloadResult")) {
                        document.querySelector("#downloadResult").style.display = "block";
                    }

                    // remove start now on expired
                    if (modalFooter.lastElementChild.textContent == "Start Now") {
                        modalFooter.removeChild(modalFooter.lastChild);
                    }

                    // remove end now on expired
                    modalFooter.childNodes.forEach(el => {
                        if (el.textContent == "End Now") {
                            modalFooter.removeChild(el);
                        }
                    });

                    return;
                } else {
                    modalName.textContent = data.examName;
                    modalWrapper.id = data.examID;
                    modal_startTime.innerHTML = `<p>Start Time: ${Sdate ? `${Syear} ${Smonth} ${Sday}` : "Not yet started!"}</p>
                    <p>End Time: ${Eyear} ${Emonth} ${Eday}</p>`;

                    // remove start btn if status is 1 or started
                    if (modalFooter.lastElementChild.textContent == "Download Result") {
                        document.querySelector("#downloadResult").style.display = "none";
                    }
                    if (data.status == 1) {
                        // add end btn
                        const endBtn = document.createElement("button");
                        endBtn.type = "button";
                        endBtn.classList = "btn btn-warning";
                        endBtn.textContent = "End Now";

                        endBtn.addEventListener("click", () => {
                            // start exam send to the backend controller
                            fetch("http://localhost/OnlineExamApp/controller/end_exam.controller.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                                body: JSON.stringify({ eid: parseInt(examID.id) })
                            })
                                .then(res => res.json())
                                .then(data => {
                                    console.log(data);
                                    if (data.status == "SUCCESS") {
                                        window.location.reload();
                                    }
                                });
                        });

                        // remove start now on progress
                        modalFooter.childNodes.forEach(el => {
                            if (el.textContent == "Start Now") {
                                modalFooter.removeChild(el);
                            }
                        });

                        modalFooter.appendChild(endBtn);
                        return;
                    }

                    // remove end now on progress
                    modalFooter.childNodes.forEach(el => {
                        if (el.textContent == "End Now") {
                            modalFooter.removeChild(el);
                        }
                    });

                    if (document.querySelector("#downloadResult")) {
                        document.querySelector("#downloadResult").style.display = "none";
                    }

                    // check if exam has started
                    // add start button if not
                    if (data.status != 1) {
                        if (modalFooter.lastElementChild.textContent !== "Start Now") {
                            const startBtn = document.createElement("button");
                            startBtn.type = "button";
                            startBtn.classList = "btn btn-success";
                            startBtn.textContent = "Start Now";

                            startBtn.addEventListener("click", () => {
                                // start exam send to the backend controller
                                fetch("http://localhost/OnlineExamApp/controller/start_exam.controller.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json"
                                    },
                                    referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                                    body: JSON.stringify({ eid: parseInt(examID.id) })
                                })
                                    .then(res => res.json())
                                    .then(data => {
                                        console.log(data);
                                        if (data.status == "SUCCESS") {
                                            window.location.reload();
                                        }
                                    });
                            });

                            modalFooter.appendChild(startBtn);
                        }
                    }
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
