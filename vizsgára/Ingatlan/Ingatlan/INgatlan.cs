using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Ingatlan
{
    class INgatlan
    {
        protected int ar, terulet;
        protected string cim, tulajdonos, tipus;

        //jellemzőt, ami kivételt dob akkor, ha az ár kisebb mint 1000000 Ft
        public int Ar
        {
            get  //olvasáskor fut le, visszaad értéket
            { 
                return ar;
            }
            set //íráskor fut le, value paraméterben lesz az átadandó érték
            {
                if (value < 1000000)
                {
                    throw new Exception("Hibás ár!");
                }
                ar = value;
            }

        }
        public INgatlan(int ar, int terulet, string cim, string tulajdonos)
        {
            Ar = ar;
            this.cim = cim;
            this.terulet = terulet;
            this.tulajdonos = tulajdonos;
        }

        public INgatlan(int terulet, string cim, string tulajdonos)
        {
            this.ar = 1000000;
            this.cim = cim;
            this.terulet = terulet;
            this.tulajdonos = tulajdonos;
        }
    }
}
