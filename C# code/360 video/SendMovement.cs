using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace Microsoft.Samples.Kinect.SpeechBasics
{
    class SendMovement
    {
        public TelnetConnection tc;

        public SendMovement(TelnetConnection tc) {
            this.tc = tc;
        }

        /// <summary>
        /// Telnet connection
        /// </summary>
        public void TelnetChar(string charToSend)
        {
            //create a new telnet connection to hostname y on port x

            string prompt = "";
            // while connected
            if (tc.IsConnected)
            {
                prompt = charToSend;
                tc.WriteLine(prompt);
                string temp = tc.Read();
            }

            using (StreamWriter w = File.AppendText("logFile.txt"))
            {
                Log(charToSend + " send to raspberry through telnet.", w);
            }
            Thread.Sleep(100);

            //  500 is 5sec
            //  25 is 0.25sec
        }

        public static void Log(string logMessage, TextWriter w)
        {
            // w.Write("\nLog Entry : ");
            w.WriteLine("\n{0}", DateTime.Now);
            w.WriteLine("\r : {0}", logMessage);
        }
    }
}
