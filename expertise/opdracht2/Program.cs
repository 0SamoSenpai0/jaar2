using System;

namespace StudentAndTeacher
{
    public class Person
    {
        private string name;
        private string address;

        public Person(string name, string address)
        {
            this.name = name;
            this.address = address;
        }

        public string GetName()
        {
            return name;
        }

        public string GetAddress()
        {
            return address;
        }

        public void SetAddress(string address)
        {
            this.address = address;
        }

        public override string ToString()
        {
            return $"Person[name={name}, address={address}]";
        }
    }

    public class Student : Person
    {
        private string program;
        private int year;
        private double fee;

        public Student(string name, string address, string program, int year, double fee)
            : base(name, address)
        {
            this.program = program;
            this.year = year;
            this.fee = fee;
        }

        public string GetProgram()
        {
            return program;
        }

        public void SetProgram(string program)
        {
            this.program = program;
        }

        public int GetYear()
        {
            return year;
        }

        public void SetYear(int year)
        {
            this.year = year;
        }

        public double GetFee()
        {
            return fee;
        }

        public void SetFee(double fee)
        {
            this.fee = fee;
        }

        public override string ToString()
        {
            return $"Student[Person[name={GetName()}, address={GetAddress()}], program={program}, year={year}, fee={fee}]";
        }
    }

    public class Staff : Person
    {
        private string school;
        private double pay;

        public Staff(string name, string address, string school, double pay)
            : base(name, address)
        {
            this.school = school;
            this.pay = pay;
        }

        public string GetSchool()
        {
            return school;
        }

        public void SetSchool(string school)
        {
            this.school = school;
        }

        public double GetPay()
        {
            return pay;
        }

        public void SetPay(double pay)
        {
            this.pay = pay;
        }

        public override string ToString()
        {
            return $"Staff[Person[name={GetName()}, address={GetAddress()}], school={school}, pay={pay}]";
        }
    }


    class Program
    {
        static void Main(string[] args)
        {
            Student student1 = new Student("Embiya Gürses", "Palissanderstraat 30, Rotterdam", "Software development", 2, 1357.00);
            Student student2 = new Student("Erik van der Wiel", "ergensinbarendrecht 123, Barendrecht", "Software development", 2, 1357.00);
            Student student3 = new Student("Yermaih Waterfort", "Boogjes 16, Rotterdam", "Software development", 2, 1357.00);

            Staff docent1 = new Staff("sasha grom", "Rozemarijnsingel 26, Utrecht", "UvA", 3100.00);
            Staff docent2 = new Staff("thomas van kerkse", "Bieslookstraat 12, Utrecht", "TU Delft", 3300.00);

            Console.WriteLine(student1.ToString());
            Console.WriteLine(student2.ToString());
            Console.WriteLine(student3.ToString());
            Console.WriteLine(docent1.ToString());
            Console.WriteLine(docent2.ToString());

            Console.WriteLine("Druk op een toets om af te sluiten...");
            Console.ReadKey();
        }
    }
}
