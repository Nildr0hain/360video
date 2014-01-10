using System;
using System.Windows.Forms;

namespace Projecten02
{
    public partial class Form1 : Form
    {        
        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            SenseMovement s = new SenseMovement();
            s.Start();
            SpeechRecognition v = new SpeechRecognition();
            string[] arg = new string[2];
            arg[0] = "Stop";
            arg[1] = "Switch";
            v.setup(arg);

        }   

    }
}
