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
    public partial class frmSekrerterinSayfasi : Form
    {
        public int sekreterID;
        public frmSekrerterinSayfasi(int gelenID)
        {
            InitializeComponent();
            sekreterID = gelenID;
        }

        private void frmSekrerterinSayfasi_Load(object sender, EventArgs e)
        {

        }
    }
}
