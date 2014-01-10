using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using AxAXVLC;

namespace testVLC
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {            
            string uri ="http://"+ ipAC.Text + ":" + txtPort.Text;
            vlcplugin.addTarget(uri, null, AXVLC.VLCPlaylistMode.VLCPlayListAppendAndGo, 0);
            
            vlcplugin.play();
            
        }
    }
}
