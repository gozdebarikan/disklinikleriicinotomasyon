using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace disklinikleriicinotomasyon
{
    public partial class frmDoktorSayfasi : Form
    {
        public int doktorID;
        public frmDoktorSayfasi(int gelenID)
        {
            InitializeComponent();

            doktorID = gelenID;
        }

        private void frmDoktorSayfasi_Load(object sender, EventArgs e)
        {

        }
    }
}
