<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فريق العمل</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #007bff;
            padding: 20px;
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 40px 0;
        }

        .team-section {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .team-member {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .team-member img {
            width: 100%;
            height: 330px;
            object-fit: cover;
            border-radius: 8px;
            border-bottom: 2px solid #f1f1f1;
        }

        .team-member h3 {
            margin: 15px 0;
            font-size: 22px;
            font-weight: 600;
            color: #007bff;
        }

        .team-member p {
            margin: 0 20px;
            color: #555;
            font-size: 16px;
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        /* Responsive for small screens */
        @media (max-width: 768px) {
            .team-section {
                flex-direction: column;
                justify-content: center;
            }

            .team-member {
                width: 80%;
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>فريق العمل</h1>
    </header>

    <div class="container">
        <div class="team-section">
            <!-- Your Info -->
            <div class="team-member">
                <img src="img/eihab.jpg" alt="إيهاب">
                <h3>EIhab Adel Shokry</h3>
                <p><strong>المسمى الوظيفي:</strong> مطور ويب خلفي (Back-End Developer)</p>
                <p><strong>التخصص:</strong> تطوير تطبيقات الويب باستخدام PHP وMySQL</p>
                <p><strong>الخبرات:</strong> لدي خبرة في تطوير المواقع الإلكترونية باستخدام PHP، MySQL، وLaravel. كما أنني أتعامل مع واجهات التطبيقات API وأعشق تحسين أداء النظام وتحقيق أفضل نتائج للمستخدمين.</p>
                <p><strong>الهوايات:</strong> تطوير البرمجيات، قراءة الكتب التقنية، استكشاف التقنيات الجديدة في عالم البرمجة.</p>
                <p><strong>الشهادات:</strong> شهادة في علوم الحاسوب، دراسات خاصة في البرمجة  .</p>
            </div>
        </div>
    </div>

    <footer>
        <p>حقوق النشر &copy; 2024 جميع الحقوق محفوظة</p>
    </footer>
</body>

</html>