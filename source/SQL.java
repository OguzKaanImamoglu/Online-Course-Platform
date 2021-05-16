import java.sql.*;
class SQL{
    public static void main(String args[]){
        try{
            Class.forName("com.mysql.jdbc.Driver");

            Connection con=DriverManager.getConnection(
                    "jdbc:mysql://dijkstra.cs.bilkent.edu.tr:3306/can_alpay","can.alpay","lY38nY8F");

            Statement stmt=con.createStatement();
            DatabaseMetaData meta = con.getMetaData();
            //Person Table
            ResultSet exist = meta.getTables(null, null, "person", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE person(" +
                        "person_id INT PRIMARY KEY AUTO_INCREMENT," +
                        "username VARCHAR(24) NOT NULL UNIQUE," +
                        "email VARCHAR(64) NOT NULL UNIQUE," +
                        "name VARCHAR(32) NOT NULL," +
                        "surname VARCHAR(32) NOT NULL, " +
                        "password VARCHAR(32) NOT NULL, " +
                        "date_of_birth DATE DEFAULT NULL" +
                        ")ENGINE = INNODB;");

                //USERNAME INDEX
                stmt.executeUpdate("CREATE INDEX idx_username ON person(username)");
            }else{
                System.out.println("PERSON EXIST");
            }



            // Student Table
            exist = meta.getTables(null, null, "student", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE student(" +
                        "student_id INT PRIMARY KEY," +
                        "FOREIGN KEY (student_id) REFERENCES person(person_id)" +
                        "ON DELETE CASCADE " +
                        "ON UPDATE RESTRICT," +
                        "wallet NUMERIC(10, 2) DEFAULT 0," +
                        "CONSTRAINT check_wallet " +
                        "CHECK (wallet >= 0)" +
                        ") ENGINE = INNODB;");
            }else{
                System.out.println("STUDENT EXIST");
            }

            // course_creator Table
            exist = meta.getTables(null, null, "course_creator", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE course_creator(\n" +
                        "\tcourse_creator_id INT,\n" +
                        "\tFOREIGN KEY (course_creator_id) REFERENCES person(person_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "\twallet NUMERIC(10, 2) DEFAULT 0,\n" +
                        "\trating NUMERIC(2,1) DEFAULT 0,\n" +
                        "\tPRIMARY KEY (course_creator_id),\n" +
                        "\tCONSTRAINT check_course_creator_rating_positivity\n" +
                        "\t\tCHECK (rating >= 0 AND rating <= 5),\n" +
                        "\tCONSTRAINT check_course_creator_wallet_positivity\n" +
                        "\t\tCHECK (wallet >= 0)\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("course_creator EXIST");
            }

            // admin Table
            exist = meta.getTables(null, null, "admin", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE admin(\n" +
                        "\tadmin_id INT PRIMARY KEY,\n" +
                        "\tFOREIGN KEY (admin_id) REFERENCES person(person_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("admin EXIST");
            }

            // course Table
            exist = meta.getTables(null, null, "course", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE course(\n" +
                        "\tcourse_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\tcourse_name VARCHAR(60) NOT NULL,\n" +
                        "language VARCHAR(50),\n" +
                        "course_price NUMERIC(5, 2) DEFAULT 0,\n" +
                        "create_date DATE DEFAULT CURRENT_DATE, \n" +
                        "average_rating NUMERIC(2, 1) DEFAULT 0,\n" +
                        "category VARCHAR(30) CHECK (category in \n" +
                        "('Web Development', 'Mobile Software Development', \n" +
                        "'Programming Languages', 'Game Development', 'Database Management System', 'Business', 'Management', 'Economics', 'Finance', 'Information Technology', 'Cyber Security', 'Maths', 'Gastronomy', 'Others')),\n" +
                        "course_description VARCHAR(200),\n" +
                        "course_creator_id INT,\n" +
                        "FOREIGN KEY (course_creator_id) REFERENCES     \tcourse_creator(course_creator_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "CONSTRAINT check_course_price_validity CHECK (course_price >= 0),\n" +
                        "CONSTRAINT check_average_rating_validity CHECK (average_rating >= 0 AND average_rating <= 5),\n" +
                        ") ENGINE = INNODB;\n");

                //course creator index
                stmt.executeUpdate("CREATE INDEX idx_courses_course_creator_id ON course(course_creator_id)");

            }else{
                System.out.println("course EXIST");
            }



            // enrolls Table
            exist = meta.getTables(null, null, "enrolls", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE enrolls(\n" +
                        "\tstudent_id INT,\n" +
                        "\tcourse_id INT,\n" +
                        "\tpurchased_price NUMERIC(5, 2),\n" +
                        "\tpurchase_date DATE,\n" +
                        "\tPRIMARY KEY(student_id, course_id),\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("enrolls EXIST");
            }

            // adds_to_cart Table
            exist = meta.getTables(null, null, "adds_to_cart", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE adds_to_cart(\n" +
                        "\tstudent_id INT,\n" +
                        "\tcourse_id INT,\n" +
                        "\tPRIMARY KEY(student_id, course_id),\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("adds_to_cart EXIST");
            }

            // adds_to_wishlist Table
            exist = meta.getTables(null, null, "adds_to_wishlist", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE adds_to_wishlist(\n" +
                        "\tstudent_id INT,\n" +
                        "\tcourse_id INT,\n" +
                        "\tPRIMARY KEY(student_id, course_id),\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("adds_to_wishlist EXIST");
            }

            // lecture Table
            exist = meta.getTables(null, null, "lecture", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE lecture(\n" +
                        "\tcourse_id INT,\n" +
                        "\tlecture_id INT,\n" +
                        "\tlecture_name VARCHAR(64) NOT NULL,\n" +
                        "\tduration TIME NOT NULL,\n" +
                        "\tdescription VARCHAR(360),\n" +
                        "\tPRIMARY KEY (course_id, lecture_id),\n" +
                        "\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "\tON DELETE CASCADE,\n" +
                        "CONSTRAINT check_duration_validity\n" +
                        "\t\tCHECK(duration > 0)\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("lecture EXIST");
            }

            // progresses Table
            exist = meta.getTables(null, null, "progresses", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE progresses(\n" +
                        "\tstudent_id INT,\n" +
                        "\tcourse_id INT,\n" +
                        "lecture_id INT,\n" +
                        "\tPRIMARY KEY(student_id, course_id, lecture_id),\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "FOREIGN KEY (course_id, lecture_id) REFERENCES lecture(course_id, lecture_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "FOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "ON UPDATE CASCADE\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("progresses EXIST");
            }

            // assignment Table
            exist = meta.getTables(null, null, "assignment", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE assignment(\n" +
                        "\t\tassignment_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\t\tassignment_question VARCHAR(100) NOT NULL,\n" +
                        "\t\tassignment_threshold INT,\n" +
                        "\t\tcourse_id INT,\n" +
                        "\t\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "\t\tON DELETE CASCADE\n" +
                        "\t\tON UPDATE RESTRICT,\n" +
                        "\t\tCONSTRAINT check_threshold\n" +
                        "\t\t\t\tCHECK (assignment_threshold>=0)\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("assignment EXIST");
            }

            // submitted_assignment Table
            exist = meta.getTables(null, null, "submitted_assignment", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE  submitted_assignment(\n" +
                        "\t\tassignment_id INT,\n" +
                        "student_id INT,\n" +
                        "submission_time TIMESTAMP,\n" +
                        "\t\tassignment_answer VARCHAR(300) NOT NULL,\n" +
                        "\t\tgrade INT DEFAULT 0,\n" +
                        "\t\tis_graded BOOLEAN DEFAULT FALSE,\n" +
                        "\t\tPRIMARY KEY (assignment_id, student_id, submission_time),\n" +
                        "\t\tFOREIGN KEY (assignment_id) REFERENCES assignment(assignment_id)\n" +
                        "\t\tON DELETE CASCADE\n" +
                        "\t\tON UPDATE RESTRICT,\n" +
                        "FOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "\t\tON DELETE CASCADE\n" +
                        "\t\tON UPDATE RESTRICT,\n" +
                        "CONSTRAINT check_grade_validity\n" +
                        "\t\t\tCHECK(grade >= 0)\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("submitted_assignment EXIST");
            }

            // question Table
            exist = meta.getTables(null, null, "question", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE question(\n" +
                        "\t\tquestion_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\t\tquestion_text VARCHAR(200) NOT NULL,\n" +
                        "\t\tdate DATE NOT NULL\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("question EXIST");
            }

            // announcement Table
            exist = meta.getTables(null, null, "announcement", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE announcement(\n" +
                        "\tannouncement_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\ttext VARCHAR(500) NOT NULL,\n" +
                        "\tdate DATE,\n" +
                        "\tcourse_id INT,\n" +
                        "\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");

                //courses_id index
                stmt.executeUpdate("CREATE INDEX idx_ann_course_id ON announcement(course_id)");

            }else{
                System.out.println("announcement EXIST");
            }

            // discount Table
            exist = meta.getTables(null, null, "discount", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE discount(\n" +
                        "\tdiscount_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\tdiscounted_course_id INT UNIQUE,\n" +
                        "\tallower_course_creator_id INT,\n" +
                        "\tis_allowed BOOLEAN DEFAULT FALSE,\n" +
                        "\tstart_date DATE,\n" +
                        "\tend_date DATE,\n" +
                        "\tpercentage INT,\n" +
                        "\tFOREIGN KEY (discounted_course_id) REFERENCES course(course_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "FOREIGN KEY (allower_course_creator_id) REFERENCES course_creator(course_creator_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "\tCONSTRAINT check_percentage_validity CHECK (percentage > 0 AND percentage <= 100)\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("discount EXIST");
            }

            // refund Table
            exist = meta.getTables(null, null, "refund", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE refund(\n" +
                        "\trefund_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\treason VARCHAR(320) NOT NULL,\n" +
                        "\tis_assessed BOOLEAN DEFAULT FALSE,\n" +
                        "\tis_approved BOOLEAN DEFAULT FALSE\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("refund EXIST");
            }

            // refund_requests  Table
            exist = meta.getTables(null, null, "refund_requests", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE refund_requests (\n" +
                        "\trefund_id INT PRIMARY KEY,\n" +
                        "\tstudent_id INT,\n" +
                        "course_id INT,\n" +
                        "FOREIGN KEY (refund_id) REFERENCES refund(refund_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "FOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("refund_requests EXIST");
            }

            // complaint Table
            exist = meta.getTables(null, null, "complaint", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE complaint (\n" +
                        "\tcomplaint_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\tcomplaint_note VARCHAR(360) NOT NULL,\n" +
                        "\tcomplaint_date DATE NOT NULL\n" +
                        ") ENGINE = INNODB;\n");


            }else{
                System.out.println("complaint EXIST");
            }

            // feedback Table
            exist = meta.getTables(null, null, "feedback", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE feedback(\n" +
                        "feedback_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "feedback_note VARCHAR(360) NOT NULL,\n" +
                        "rating NUMERIC(2,1) DEFAULT 0,\n" +
                        "CONSTRAINT check_rating CHECK (rating >= 0)\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("feedback EXIST");
            }

            // certificate Table
            exist = meta.getTables(null, null, "certificate", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE certificate (\n" +
                        "\tcertificate_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\tdate DATE NOT NULL,\n" +
                        "\ttext VARCHAR(120) NOT NULL\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("certificate EXIST");
            }

            // student_complaints Table
            exist = meta.getTables(null, null, "student_complaints", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE student_complaints (\n" +
                        "\tcomplaint_id INT PRIMARY KEY,\n" +
                        "student_id INT,\n" +
                        "\tcourse_id INT,\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (complaint_id) REFERENCES complaint(complaint_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE INNODB;\n");

                stmt.executeUpdate("CREATE VIEW complaint_view AS\n" +
                        "SELECT C.complaint_id, complaint_note, complaint_date, P.person_id, Co.course_id, name, surname, course_name\n" +
                        "FROM complaint C, student_complaints SC, person P, course Co\n" +
                        "WHERE \n" +
                        "C.complaint_id=SC.complaint_id AND P.person_id=SC.student_id AND\n" +
                        "SC.course_id=Co.course_id\n");
            }else{
                System.out.println("student_complaints EXIST");
            }
    //asdas
            // student_feedbacks Table
            exist = meta.getTables(null, null, "student_feedbacks", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE student_feedbacks (\n" +
                        "\tfeedback_id INT UNIQUE,\n" +
                        "student_id INT,\n" +
                        "\tcourse_id INT,\n" +
                        "\tPRIMARY KEY (student_id, course_id),\n" +
                        "\tFOREIGN KEY (student_id) references student(student_id)\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_id) references course(course_id)\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (feedback_id) references feedback(feedback_id)\n" +
                        "\t\t\t\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");


                stmt.executeUpdate("\n" +
                        "CREATE TRIGGER update_rating AFTER INSERT ON student_feedbacks FOR EACH ROW\n" +
                        "  BEGIN\n" +
                        "  SET @COUNT=(SELECT COUNT(*) FROM student_feedbacks WHERE (course_id=NEW.course_id));\n" +
                        "  SET @SUM = (SELECT SUM(f.rating) FROM feedback f, student_feedbacks sf WHERE (f.feedback_id = sf.feedback_id AND sf.course_id = NEW.course_id));\n" +
                        "  IF @COUNT=0 THEN\n" +
                        "  UPDATE course SET average_rating = 0 WHERE course_id = NEW.course_id;\n" +
                        "  ELSE\n" +
                        "  UPDATE course SET average_rating = (@SUM * 1.0)/(@COUNT * 1.0) WHERE course_id = NEW.course_id;\n" +
                        "  END IF;\n" +
                        "  END;\n" +
                        "  \n" +
                        "  \n");

                stmt.executeUpdate("\n" +
                        "CREATE TRIGGER update_rating2 AFTER UPDATE ON feedback FOR EACH ROW\n" +
                        "  BEGIN\n" +
                        "  SET @c_id = (SELECT course_id FROM student_feedbacks WHERE feedback_id = NEW.feedback_id);\n"+
                        "  SET @COUNT=(SELECT COUNT(*) FROM student_feedbacks WHERE (course_id=@c_id));\n" +
                        "  SET @SUM = (SELECT SUM(f.rating) FROM feedback f, student_feedbacks sf WHERE (f.feedback_id = sf.feedback_id AND sf.course_id = @c_id));\n" +
                        "  IF @COUNT=0 THEN\n" +
                        "  UPDATE course SET average_rating = 0 WHERE course_id = @c_id;\n" +
                        "  ELSE\n" +
                        "  UPDATE course SET average_rating = (@SUM * 1.0)/(@COUNT * 1.0) WHERE course_id = @c_id;\n" +
                        "  END IF;\n" +
                        "  END;\n" +
                        "  \n" +
                        "  \n");


                stmt.executeUpdate("\n" +
                        "CREATE TRIGGER update_rating3 AFTER INSERT ON student_feedbacks FOR EACH ROW\n" +
                        "  BEGIN\n" +
                        "  SET @cc_id = (SELECT DISTINCT course_creator_id FROM course WHERE (course_id = NEW.course_id));\n" +
                        "  SET @COUNT=(SELECT COUNT(*) FROM course WHERE (course_creator_id=@cc_id));\n" +
                        "  SET @SUM = (SELECT SUM(average_rating) FROM course WHERE (course_creator_id = @cc_id));\n" +
                        "  IF @COUNT=0 THEN\n" +
                        "  UPDATE course_creator SET RATING = 0 WHERE course_creator_id = @cc_id;\n" +
                        "  ELSE\n" +
                        "  UPDATE course_creator SET RATING = (@SUM * 1.0)/(@COUNT * 1.0) WHERE course_creator_id = @cc_id;\n" +
                        "  END IF;\n" +
                        "  END;\n" +
                        "  \n" +
                        "  \n");

                stmt.executeUpdate("\n" +
                        "CREATE TRIGGER update_rating4 AFTER UPDATE ON feedback FOR EACH ROW\n" +
                        "  BEGIN\n" +
                        "  SET @cc_id = (SELECT DISTINCT C.course_creator_id FROM course C, student_feedbacks sf WHERE (C.course_id = sf.course_id AND NEW.feedback_id = sf.feedback_id));\n" +
                        "  SET @COUNT=(SELECT COUNT(*) FROM course WHERE (course_creator_id=@cc_id));\n" +
                        "  SET @SUM = (SELECT SUM(average_rating) FROM course WHERE (course_creator_id = @cc_id));\n" +
                        "  IF @COUNT=0 THEN\n" +
                        "  UPDATE course_creator SET RATING = 0 WHERE course_creator_id = @cc_id;\n" +
                        "  ELSE\n" +
                        "  UPDATE course_creator SET RATING = (@SUM * 1.0)/(@COUNT * 1.0) WHERE course_creator_id = @cc_id;\n" +
                        "  END IF;\n" +
                        "  END;\n" +
                        "  \n" +
                        "  \n");


            }else{
                System.out.println("student_feedbacks EXIST");
            }

            // earns Table
            exist = meta.getTables(null, null, "earns", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE earns(\n" +
                        "\tstudent_id INT,\n" +
                        "\tcourse_id INT,\n" +
                        "\tcertificate_id INT UNIQUE,\n" +
                        "\tPRIMARY KEY (student_id, course_id),\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (certificate_id) REFERENCES certificate(certificate_id)\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("earns EXIST");
            }

            // note Table
            exist = meta.getTables(null, null, "note", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE note(\n" +
                        "\tnote_id INT PRIMARY KEY AUTO_INCREMENT,\n" +
                        "\tstudent_id INT NOT NULL,\n" +
                        "\tlecture_id INT NOT NULL,\n" +
                        "\tcourse_id INT,\n" +
                        "\tnote_text VARCHAR(360) NOT NULL,\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_id,lecture_id) REFERENCES lecture(course_id,lecture_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "ON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("note EXIST");
            }

            // asks Table
            exist = meta.getTables(null, null, "asks", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE asks(\n" +
                        "\tquestion_id INT,\n" +
                        "\tstudent_id INT,\n" +
                        "\tcourse_id INT,\n" +
                        "\tPRIMARY KEY ( question_id ),\n" +
                        "\tFOREIGN KEY (student_id) REFERENCES student(student_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_id) REFERENCES course(course_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (question_id) REFERENCES question(question_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "ON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("asks EXIST");
            }

            // answers Table
            exist = meta.getTables(null, null, "answers", null);
            if (!exist.next()) {
                stmt.executeUpdate("CREATE TABLE answers(\n" +
                        "\tquestion_id INT PRIMARY KEY,\n" +
                        "\tcourse_creator_id INT,\n" +
                        "\tanswer_text VARCHAR(360) NOT NULL,\n" +
                        "\tFOREIGN KEY (question_id) references question(question_id)\n" +
                        "ON DELETE CASCADE\n" +
                        "ON UPDATE RESTRICT,\n" +
                        "\tFOREIGN KEY (course_creator_id) references course_creator(course_creator_id)\n" +
                        "\tON DELETE CASCADE\n" +
                        "\tON UPDATE RESTRICT\n" +
                        ") ENGINE = INNODB;\n");
            }else{
                System.out.println("answers EXIST");
            }


            con.close();
        }catch(Exception e){ System.out.println(e);}
    }
}