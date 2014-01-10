using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Speech.Recognition;

using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Globalization;
using System.Threading;
using Microsoft.Kinect;
using System.Speech.AudioFormat;
using System.IO;
using System.Speech.Synthesis;

namespace Projecten02
{
    
    public class VoiceCommands 
    {
        //private const string RecognizerId = "SR_MS_en-US_Kinect_11.0";
        private SpeechRecognitionEngine sre = new SpeechRecognitionEngine();
        //private StreamWriter output;
        private Stream s;
        private GrammarBuilder gb;
        private Grammar g;
        private KinectSensor kinectSensor;
        private KinectAudioSource source;
        private bool speechQueueBusy = false;
        private List<string> speechQueue = new List<string>();

        public void setup(string[] args/*, StreamWriter writer*/)
        {
            SpeechRecognitionEngine recognizer = new SpeechRecognitionEngine();
            Grammar dictationGrammar = new DictationGrammar();
            recognizer.LoadGrammar(dictationGrammar);
            try
            {
                //button1.Text = "Speak Now";
                recognizer.SetInputToDefaultAudioDevice();
                RecognitionResult result = recognizer.Recognize();
                //button1.Text = result.Text;
            }
            catch (InvalidOperationException exception)
            {
                //button1.Text = String.Format("Could not recognize input from default aduio device. Is a microphone or sound card available?\r\n{0} - {1}.", exception.Source, exception.Message);
            }
            finally
            {
                recognizer.UnloadAllGrammars();
            }    
        }

        
    }
}