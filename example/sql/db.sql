create table book (
	isbn			VARCHAR(255)	NOT NULL,
	Title			VARCHAR(255)	NOT NULL check(Title <> ''),
	Author		VARCHAR(255) NOT NULL check(Author <> ''),
	PRIMARY KEY(ISBN)
);

insert into book values ('978-0321753021', 'Component Software: Beyond Object-Oriented Programming', 'Clemens Szyperski');
insert into book values ('978-0201633610', 'Design Patterns', 'Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides');
insert into book values ('978-0201809381', 'Testing Object-Oriented Systems', 'Robert V. Binder');
insert into book values ('978-0131429383', 'Operating Systems: Design and Implementation', 'Andrew S. Tanenbaum, Albert S. Woodhull');
insert into book values ('978-0134670942', 'Introduction to Java Programming', 'Y. Daniel Liang');
insert into book values ('978-1461446989', 'Modern Compiler Design', 'Dick Grune, Kees van Reeuwijk, Henri E. Bal, Ceriel J.H. Jacobs, Koen Langendoen');
insert into book values ('978-0470167748', 'Software Architecture: Foundations, Theory, and Practice', 'R.N. Taylor, N. Medvidovic, E.M. Dashofy');
insert into book values ('978-0764574818', 'Reversing: Secrets of Reverse Engineering', 'Eldad Eilam');
insert into book values ('978-0596003128', 'Games & Diversions & Perl Culture', 'Jon Orwant');
