<?php
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["contact_submit"])) {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if ($name === "" || $email === "" || $message === "") {
        $error = "Please fill all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    } else {

        // Database connection
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "portfolio_db";

        $conn = new mysqli($host, $user, $password, $database);

        if ($conn->connect_error) {
            $error = "Database connection failed.";
        } else {

            $stmt = $conn->prepare(
                "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)"
            );

            if ($stmt) {
                $stmt->bind_param("sss", $name, $email, $message);

                if ($stmt->execute()) {
                    $success = "Message sent successfully!";
                } else {
                    $error = "Unable to send message.";
                }

                $stmt->close();
            } else {
                $error = "Database error.";
            }

            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mukila M | Portfolio</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f7f8ff;
            color: #222;
            line-height: 1.6;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: white;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            z-index: 1000;
        }

        .nav-container {
            max-width: 1100px;
            margin: auto;
            padding: 18px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #6846d9;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: #6846d9;
        }

        section {
            padding: 90px 20px;
        }

        .container {
            max-width: 1050px;
            margin: auto;
        }

        #home {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #eef3ff, #f7efff);
        }

        .hero {
            text-align: center;
            width: 100%;
        }

        .hero h1 {
            font-size: 55px;
            color: #6846d9;
            margin-bottom: 10px;
        }

        .hero h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .hero p {
            max-width: 650px;
            margin: auto;
            color: #555;
            font-size: 18px;
        }

        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 28px;
            background: #6846d9;
            color: white;
            text-decoration: none;
            border-radius: 25px;
        }

        .btn:hover {
            background: #5132bd;
        }

        .section-title {
            text-align: center;
            font-size: 35px;
            color: #6846d9;
            margin-bottom: 40px;
        }

        .about-box {
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: #6846d9;
            margin-bottom: 10px;
        }

        .skills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        .skill {
            background: #e9e2ff;
            color: #5735c5;
            padding: 10px 18px;
            border-radius: 20px;
            font-weight: bold;
        }

        .contact-form {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 13px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
        }

        .contact-form textarea {
            height: 130px;
            resize: vertical;
        }

        .contact-form button {
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .success {
            background: #dff7e5;
            color: #167532;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .error {
            background: #ffe0e0;
            color: #b00020;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        footer {
            text-align: center;
            background: #21184a;
            color: white;
            padding: 25px;
        }

        @media (max-width: 700px) {

            .nav-container {
                flex-direction: column;
                gap: 10px;
            }

            .nav-links {
                gap: 12px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero h1 {
                font-size: 40px;
            }

            .hero h2 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

<nav>
    <div class="nav-container">
        <div class="logo">Mukila M</div>

        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#academics">Academics</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#achievements">Achievements</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#internship">Internship</a></li>
            <li><a href="#certifications">Certifications</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
</nav>


<!-- HOME -->

<section id="home">
    <div class="hero">
        <h1>Mukila M</h1>

        <h2>Computer Science & Engineering Student</h2>

        <p>
            Welcome to my portfolio. I am passionate about software development,
            web technologies, data science and building useful applications.
        </p>

        <a href="#about" class="btn">Explore My Portfolio</a>
    </div>
</section>


<!-- ABOUT -->

<section id="about">
    <div class="container">

        <h2 class="section-title">About Me</h2>

        <div class="about-box">
            <p>
                I am Mukila M, a Computer Science and Engineering student
                at Kamaraj College of Engineering & Technology.
                I am interested in software development, web development,
                data science and problem solving.
            </p>

            <br>

            <p>
                I enjoy learning new technologies and developing projects
                that solve real-world problems.
            </p>
        </div>

    </div>
</section>


<!-- ACADEMICS -->

<section id="academics">
    <div class="container">

        <h2 class="section-title">Academic Details</h2>

        <div class="cards">

            <div class="card">
                <h3>Degree</h3>
                <p>B.E. Computer Science and Engineering</p>
            </div>

            <div class="card">
                <h3>College</h3>
                <p>Kamaraj College of Engineering & Technology</p>
            </div>

            <div class="card">
                <h3>CGPA</h3>
                <p>8.5</p>
            </div>

            <div class="card">
                <h3>Graduation</h3>
                <p>2028</p>
            </div>

        </div>

    </div>
</section>


<!-- PROJECTS -->

<section id="projects">
    <div class="container">

        <h2 class="section-title">Projects</h2>

        <div class="cards">

            <div class="card">
                <h3>Smart Contact Management System</h3>

                <p>
                    A contact management application developed using
                    Python and Data Structures & Algorithms.
                </p>

                <br>

                <strong>Technologies:</strong>
                <p>Python, DSA</p>
            </div>


            <div class="card">
                <h3>CampusTrace</h3>

                <p>
                    Campus Lost & Found Management System designed
                    to help students manage and find lost items.
                </p>

                <br>

                <strong>Technologies:</strong>
                <p>React.js, Node.js, Express.js, MongoDB</p>
            </div>

        </div>

    </div>
</section>


<!-- ACHIEVEMENTS -->

<section id="achievements">
    <div class="container">

        <h2 class="section-title">Achievements</h2>

        <div class="cards">

            <div class="card">
                <h3>DeepStegNet</h3>
                <p>MSME Project Proposal</p>
            </div>

            <div class="card">
                <h3>Smart Helmet</h3>
                <p>IoT-Based Smart Helmet for Rider Safety</p>
            </div>

            <div class="card">
                <h3>Sign to Speak</h3>
                <p>Sign to Speak project using Python</p>
            </div>

        </div>

    </div>
</section>


<!-- SKILLS -->

<section id="skills">
    <div class="container">

        <h2 class="section-title">Skills</h2>

        <div class="skills">

            <span class="skill">C</span>
            <span class="skill">Java</span>
            <span class="skill">Python</span>
            <span class="skill">JavaScript</span>
            <span class="skill">HTML</span>
            <span class="skill">CSS</span>
            <span class="skill">React.js</span>
            <span class="skill">Node.js</span>
            <span class="skill">Express.js</span>
            <span class="skill">MySQL</span>
            <span class="skill">MongoDB</span>
            <span class="skill">NumPy</span>
            <span class="skill">Pandas</span>
            <span class="skill">Scikit-learn</span>
            <span class="skill">Git</span>
            <span class="skill">VS Code</span>

        </div>

    </div>
</section>


<!-- INTERNSHIP -->

<section id="internship">
    <div class="container">

        <h2 class="section-title">Internship</h2>

        <div class="cards">

            <div class="card">

                <h3>Lamda Tech Softics</h3>

                <p>
                    <strong>Role:</strong> Trainee
                </p>

                <p>
                    <strong>Domain:</strong> Library Management
                </p>

                <p>
                    <strong>Location:</strong> Virudhunagar
                </p>

                <p>
                    <strong>Duration:</strong>
                    05 December 2025 - 26 December 2025
                </p>

            </div>

        </div>

    </div>
</section>


<!-- CERTIFICATIONS -->

<section id="certifications">
    <div class="container">

        <h2 class="section-title">Certifications</h2>

        <div class="cards">

            <div class="card">
                <h3>Infosys Springboard</h3>
                <p>Professional Learning Certification</p>
            </div>

            <div class="card">
                <h3>CCNA</h3>
                <p>Cisco Certified Network Associate</p>
            </div>

            <div class="card">
                <h3>.NET / C#</h3>
                <p>Programming Certification</p>
            </div>

            <div class="card">
                <h3>Data Analytics</h3>
                <p>Data Analytics Certification</p>
            </div>

        </div>

    </div>
</section>


<!-- CONTACT -->

<section id="contact">

    <div class="container">

        <h2 class="section-title">Contact Me</h2>

        <div class="contact-form">

            <?php if ($success): ?>

                <div class="success">
                    <?php echo htmlspecialchars($success); ?>
                </div>

            <?php endif; ?>


            <?php if ($error): ?>

                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <form method="POST" action="#contact">

                <input
                    type="text"
                    name="name"
                    placeholder="Your Name"
                    required
                >

                <input
                    type="email"
                    name="email"
                    placeholder="Your Email"
                    required
                >

                <textarea
                    name="message"
                    placeholder="Your Message"
                    required
                ></textarea>

                <button
                    type="submit"
                    name="contact_submit"
                    class="btn"
                >
                    Send Message
                </button>

            </form>

        </div>

    </div>

</section>


<!-- FOOTER -->

<footer>

    <p>
        © 2026 Mukila M. All Rights Reserved.
    </p>

</footer>

</body>
</html>